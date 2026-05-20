#!/bin/bash
echo "Running Pre-commit Checks..."
npm run build
npm run lint
find . -name "*.php" -not -path "./node_modules/*" -exec php -l {} \; | grep -v "No syntax errors"
echo "Pre-commit checks done."
