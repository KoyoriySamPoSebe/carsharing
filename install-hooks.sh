#!/bin/bash

# Set the Git hooks directory
HOOKS_DIR="git-hooks"

# Copy hooks to .git/hooks
if [ -d ".git" ]; then
    echo "Installing Git hooks..."
    cp -r $HOOKS_DIR/* .git/hooks/
    chmod +x .git/hooks/*
    echo "Git hooks installed."
else
    echo "Error: Not in a Git repository."
    exit 1
fi
