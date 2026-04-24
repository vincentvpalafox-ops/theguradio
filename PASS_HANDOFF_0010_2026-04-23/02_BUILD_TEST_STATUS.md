# 02 BUILD TEST STATUS

## Commands Run

| Command | Result | Key output excerpt |
| --- | --- | --- |
| `Select-String` on `ConsoleHost_history.txt` for deploy-related terms | pass | found only a generic placeholder SSH example, not a reusable real command |
| `Get-ChildItem $env:USERPROFILE\.ssh` | pass | found `id_ed25519`, `id_ed25519.pub`, and `known_hosts` |
| `Get-Content $env:USERPROFILE\.ssh\known_hosts` | pass | confirmed trusted entries for `theguradio.com`, `ftp.theguradio.com`, `peak.theguradio.com`, and `webhosting2021.is.cc` |
| `ssh -i ... -o BatchMode=yes ... \"pwd\"` against `thegalla@theguradio.com`, `thegalla@ftp.theguradio.com`, `thegalla@peak.theguradio.com`, `vince@theguradio.com`, `admin@theguradio.com`, `vincent@theguradio.com`, and `thegalla@webhosting2021.is.cc` | pass | every probe reached the host but failed with `Permission denied (publickey,gssapi-keyex,gssapi-with-mic,password)` |
| `cmdkey /list` | pass | no stored credential entry was obviously tied to `theguradio.com` hosting or cPanel |
| Search of user profile/app configs for `theguradio.com` plus deploy-client configs | pass | no reusable FileZilla or WinSCP site configuration was found |
| `curl.exe -k -sS -o NUL -w "... %{http_code}\n" https://theguradio.com:2083` | pass | `200` |
| `curl.exe -k -sS -o NUL -w "... %{http_code}\n" https://webhosting2021.is.cc:2083` | pass | `200` |
| `curl.exe -k -sS -o NUL -w "... %{http_code}\n" https://ftp.theguradio.com:2083` | pass | `200` |
| `curl.exe -k -sS -o NUL -w "... %{http_code}\n" https://peak.theguradio.com:2083` | pass | `200` |

## Current Build Posture

`deployment blocked by authentication`

## Notes

- Connectivity is no longer the unknown. This machine can reach the likely hosting and cPanel surfaces.
- The blocker is now specific: no working authenticated deployment path was recoverable from the machine for the tested SSH usernames, and no reusable client config was found.
- No product code or deployment bundle contents changed in this pass.
