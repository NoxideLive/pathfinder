#!/bin/bash

# Pathfinder Mock Mode Stop Script
# This script stops the mock mode Docker container

set -e

echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║         Pathfinder - Stop Mock Mode                          ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if container is running
if docker-compose -f docker-compose.mock.yml ps | grep -q "Up"; then
    echo -e "${YELLOW}Stopping container...${NC}"
    
    if docker-compose -f docker-compose.mock.yml down; then
        echo ""
        echo -e "${GREEN}✓ Container stopped successfully${NC}"
        echo ""
        echo "To start again, run: ./start-mock.sh"
    else
        echo ""
        echo -e "${RED}✗ Failed to stop container${NC}"
        exit 1
    fi
else
    echo -e "${YELLOW}⚠ Container is not running${NC}"
    echo ""
    echo "To start the container, run: ./start-mock.sh"
fi

echo ""
