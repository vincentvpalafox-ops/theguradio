param(
    [Parameter(Mandatory = $true)]
    [string]$PreviewUrl,

    [string]$OutFile,

    [int]$TimeoutSec = 20
)

function Invoke-UrlCheck {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Url
    )

    $curlPath = Get-Command 'curl.exe' -ErrorAction SilentlyContinue
    if ($curlPath) {
        $tempBodyPath = Join-Path -Path ([System.IO.Path]::GetTempPath()) -ChildPath ("gu-preview-check-" + [guid]::NewGuid().ToString() + ".tmp")

        try {
            $meta = & $curlPath.Source `
                --location `
                --silent `
                --show-error `
                --output $tempBodyPath `
                --write-out '%{http_code}|%{url_effective}' `
                --max-redirs 5 `
                --connect-timeout $TimeoutSec `
                --max-time $TimeoutSec `
                $Url

            $statusCode = 0
            $finalUrl = $Url
            $content = ''

            if ($meta) {
                $metaParts = [string]$meta -split '\|', 2
                if ($metaParts.Count -ge 1 -and $metaParts[0] -match '^\d+$') {
                    $statusCode = [int]$metaParts[0]
                }
                if ($metaParts.Count -eq 2 -and $metaParts[1]) {
                    $finalUrl = [string]$metaParts[1]
                }
            }

            if (Test-Path -LiteralPath $tempBodyPath) {
                $content = Get-Content -Raw -LiteralPath $tempBodyPath
            }

            return [pscustomobject]@{
                url = $Url
                status_code = $statusCode
                content = [string]$content
                final_url = [string]$finalUrl
            }
        } catch {
            return [pscustomobject]@{
                url = $Url
                status_code = 0
                content = ''
                final_url = [string]$Url
            }
        } finally {
            if (Test-Path -LiteralPath $tempBodyPath) {
                Remove-Item -LiteralPath $tempBodyPath -Force -ErrorAction SilentlyContinue
            }
        }
    }

    try {
        $response = Invoke-WebRequest -Uri $Url -MaximumRedirection 5 -UseBasicParsing -TimeoutSec $TimeoutSec
        return [pscustomobject]@{
            url = $Url
            status_code = [int]$response.StatusCode
            content = [string]$response.Content
            final_url = [string]$response.BaseResponse.ResponseUri.AbsoluteUri
        }
    } catch {
        return [pscustomobject]@{
            url = $Url
            status_code = 0
            content = ''
            final_url = [string]$Url
        }
    }
}

function Test-Marker {
    param(
        [string]$Content,
        [string]$Needle
    )

    return $Content -match [regex]::Escape($Needle)
}

$preview = Invoke-UrlCheck -Url $PreviewUrl

$routeUrls = [ordered]@{
    home = 'https://theguradio.com/'
    archive = 'https://theguradio.com/archive/'
    history = 'https://theguradio.com/history/'
    performances = 'https://theguradio.com/performances/'
    search = 'https://theguradio.com/search/'
}

$routeChecks = [ordered]@{}
foreach ($routeName in $routeUrls.Keys) {
    $routeChecks[$routeName] = Invoke-UrlCheck -Url $routeUrls[$routeName]
}

$previewMarkers = [ordered]@{
    gu_homepage = (Test-Marker -Content $preview.content -Needle 'gu-homepage')
    opening = (Test-Marker -Content $preview.content -Needle 'gu-homepage-opening')
    performances = (Test-Marker -Content $preview.content -Needle 'gu-homepage-performances')
    archive = (Test-Marker -Content $preview.content -Needle 'gu-homepage-archive')
    history = (Test-Marker -Content $preview.content -Needle 'gu-homepage-history')
    community = (Test-Marker -Content $preview.content -Needle 'gu-homepage-community')
    closing = (Test-Marker -Content $preview.content -Needle 'gu-homepage-closing')
}

$previewDisallowed = [ordered]@{
    raw_shortcode_visible = (Test-Marker -Content $preview.content -Needle '[gu_scene_archive_homepage]')
    private_review_visible = (Test-Marker -Content $preview.content -Needle 'Private Review')
}

$previewMarkersOk = -not ($previewMarkers.Values -contains $false)
$previewDisallowedOk = -not ($previewDisallowed.raw_shortcode_visible -or $previewDisallowed.private_review_visible)
$routesOk = -not (($routeChecks.Values | ForEach-Object { $_.status_code }) -contains 0) -and -not (($routeChecks.Values | ForEach-Object { $_.status_code }) -contains 404) -and -not (($routeChecks.Values | ForEach-Object { $_.status_code }) -contains 500)

$result = [ordered]@{
    preview_url = $PreviewUrl
    preview_status_code = $preview.status_code
    preview_final_url = $preview.final_url
    preview_markers = $previewMarkers
    preview_markers_ok = $previewMarkersOk
    preview_disallowed = $previewDisallowed
    preview_disallowed_ok = $previewDisallowedOk
    routes = [ordered]@{
        home = $routeChecks.home.status_code
        archive = $routeChecks.archive.status_code
        history = $routeChecks.history.status_code
        performances = $routeChecks.performances.status_code
        search = $routeChecks.search.status_code
    }
    routes_ok = $routesOk
    overall_pass = ($preview.status_code -eq 200) -and $previewMarkersOk -and $previewDisallowedOk -and $routesOk
}

$json = $result | ConvertTo-Json -Depth 6

if ($OutFile) {
    $resolvedOutFile = $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($OutFile)
    $outDir = Split-Path -Path $resolvedOutFile -Parent
    if ($outDir -and -not (Test-Path $outDir)) {
        New-Item -ItemType Directory -Force -Path $outDir | Out-Null
    }
    Set-Content -LiteralPath $resolvedOutFile -Value $json -Encoding UTF8
}

$json
