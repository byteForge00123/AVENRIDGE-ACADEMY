param(
    [Parameter(ValueFromRemainingArguments = $true)]
    [string[]] $Arguments
)

$php = Join-Path $env:LOCALAPPDATA 'AvenridgeTools\php\php.exe'
$ini = Join-Path $env:LOCALAPPDATA 'AvenridgeTools\php\php.ini'

if (-not (Test-Path $php)) {
    throw 'Portable PHP is not installed. Install PHP 8.3+ and Composer, then run php artisan directly.'
}

$env:PHPRC = $ini
Push-Location (Join-Path $PSScriptRoot '..')
try {
    & $php artisan @Arguments
    if ($LASTEXITCODE -ne 0) {
        throw "Artisan exited with code $LASTEXITCODE."
    }
}
finally {
    Pop-Location
}