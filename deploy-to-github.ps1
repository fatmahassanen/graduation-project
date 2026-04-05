# PowerShell script to deploy to GitHub

Write-Host "University CMS - GitHub Deployment Script" -ForegroundColor Green
Write-Host "=========================================" -ForegroundColor Green
Write-Host ""

# Check if git is installed
if (!(Get-Command git -ErrorAction SilentlyContinue)) {
    Write-Host "Error: Git is not installed. Please install Git first." -ForegroundColor Red
    exit 1
}

# Initialize Git if not already initialized
if (!(Test-Path .git)) {
    Write-Host "Initializing Git repository..." -ForegroundColor Yellow
    git init
    Write-Host "Git initialized" -ForegroundColor Green
} else {
    Write-Host "Git already initialized" -ForegroundColor Green
}

# Check if there are any commits
$hasCommits = git rev-parse HEAD 2>$null
if (!$hasCommits) {
    Write-Host ""
    Write-Host "Adding files to Git..." -ForegroundColor Yellow
    git add .
    
    Write-Host "Creating initial commit..." -ForegroundColor Yellow
    git commit -m "Initial commit: University CMS"
    
    Write-Host "Initial commit created" -ForegroundColor Green
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "NEXT STEPS:" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Create a new repository on GitHub at: https://github.com/new"
Write-Host "2. Run these commands (replace YOUR-USERNAME):"
Write-Host ""
Write-Host "   git remote add origin https://github.com/YOUR-USERNAME/university-cms.git"
Write-Host "   git branch -M main"
Write-Host "   git push -u origin main"
Write-Host ""
