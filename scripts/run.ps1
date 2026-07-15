param(
    [Parameter(Mandatory = $true, Position = 0)]
    [string]$File
,
    [Parameter(Position = 1)]
    [string]$PhpPath
)

$xamppRoot = "C:\xampp"
$xamppPhp = Join-Path $xamppRoot "php\php.exe"

$phpCmd = $null
if ($PhpPath) {
    if (Test-Path $PhpPath) {
        $phpCmd = $PhpPath
    } else {
        Write-Host "Error: PHP executable not found: $PhpPath"
        exit 1
    }
} else {
    $phpCandidates = @(
        "php",
        $xamppPhp
    )

    foreach ($candidate in $phpCandidates) {
        if ($candidate -eq "php") {
            $resolved = Get-Command php -ErrorAction SilentlyContinue
            if ($resolved) {
                $phpCmd = $resolved.Source
                break
            }
        } elseif (Test-Path $candidate) {
            $phpCmd = $candidate
            break
        }
    }
}

if (-not $phpCmd) {
    if (Test-Path $xamppRoot) {
        if (Test-Path $xamppPhp) {
            Write-Host "Error: PHP was found in XAMPP, but it could not be started, check your PATH."
        } else {
            Write-Host "Error: PHP is not initialized yet. Open XAMPP Control Panel and complete the setup."
        }
    } else {
        Write-Host "Error: PHP not found. Install it or add XAMPP's PHP to PATH."
    }
    exit 1
}

if (-not (Test-Path $File)) {
    Write-Host "Error: file not found: $File"
    exit 1
}

Write-Host "Running $File with $phpCmd..."
& $phpCmd $File
exit $LASTEXITCODE