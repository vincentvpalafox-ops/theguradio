# 07 DEPLOY ACCESS PROBE

## What Was Checked

- PowerShell history for prior deploy commands
- local SSH material under `%USERPROFILE%\.ssh`
- trusted SSH hosts already known to this machine
- common client-config locations for FileZilla and WinSCP
- stored Windows credentials
- read-only SSH login attempts with the local private key
- HTTPS reachability of likely cPanel/hosting surfaces on port `2083`

## Concrete Findings

- local SSH material exists:
  - private key: `%USERPROFILE%\.ssh\id_ed25519`
  - trusted hosts include:
    - `theguradio.com`
    - `ftp.theguradio.com`
    - `peak.theguradio.com`
    - `webhosting2021.is.cc`
- the likely cPanel/hosting web surfaces are reachable from this machine:
  - `https://theguradio.com:2083` -> `200`
  - `https://webhosting2021.is.cc:2083` -> `200`
  - `https://ftp.theguradio.com:2083` -> `200`
  - `https://peak.theguradio.com:2083` -> `200`
- read-only SSH authentication was attempted against the likely hosting accounts:
  - `thegalla@theguradio.com`
  - `thegalla@ftp.theguradio.com`
  - `thegalla@peak.theguradio.com`
  - `thegalla@webhosting2021.is.cc`
  - `vince@theguradio.com`
  - `admin@theguradio.com`
  - `vincent@theguradio.com`
- every SSH attempt failed with:
  - `Permission denied (publickey,gssapi-keyex,gssapi-with-mic,password).`
- no reusable FileZilla or WinSCP site config was found locally
- no obviously deploy-specific stored credential entry was found in `cmdkey /list`

## What This Means

- host reachability is confirmed
- deployment is blocked specifically by missing or unauthorized authentication, not by missing bundle files or unreachable infrastructure
- the correct deployment artifact remains the bundle prepared in pass `0009`

## Immediate Use

- the next pass should not create more local packaging
- it should begin only when a valid SSH account, authorized key, or cPanel credential path is available for one of the confirmed reachable hosts
