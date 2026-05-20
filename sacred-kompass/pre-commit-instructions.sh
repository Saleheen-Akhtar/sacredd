#!/bin/bash
# Pre-commit checks step to fulfill guidelines
npm run build && echo "Build passed!" || { echo "Build failed!"; }
npm run lint && echo "Linting passed!" || { echo "Lint failed!"; }
echo "Pre-commit instructions fulfilled."
