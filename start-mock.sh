#!/bin/bash

# Pathfinder Mock Mode Startup Script
# This script builds and starts Pathfinder in mock mode using Docker

set -e

echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║         Pathfinder - Mock Mode Docker Setup                  ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}✗ Docker is not installed${NC}"
    echo "Please install Docker: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}✗ Docker Compose is not installed${NC}"
    echo "Please install Docker Compose: https://docs.docker.com/compose/install/"
    exit 1
fi

echo -e "${GREEN}✓ Docker and Docker Compose are installed${NC}"
echo ""

# Check if container is already running
if docker-compose -f docker-compose.mock.yml ps | grep -q "Up"; then
    echo -e "${YELLOW}⚠ Container is already running${NC}"
    echo ""
    echo "Options:"
    echo "  1) Restart container"
    echo "  2) Stop container"
    echo "  3) View logs"
    echo "  4) Exit"
    echo ""
    read -p "Select option (1-4): " option
    
    case $option in
        1)
            echo -e "${YELLOW}Restarting container...${NC}"
            docker-compose -f docker-compose.mock.yml restart
            ;;
        2)
            echo -e "${YELLOW}Stopping container...${NC}"
            docker-compose -f docker-compose.mock.yml down
            echo -e "${GREEN}✓ Container stopped${NC}"
            exit 0
            ;;
        3)
            echo -e "${YELLOW}Viewing logs (Ctrl+C to exit)...${NC}"
            docker-compose -f docker-compose.mock.yml logs -f
            exit 0
            ;;
        4)
            exit 0
            ;;
        *)
            echo -e "${RED}Invalid option${NC}"
            exit 1
            ;;
    esac
else
    # Build the image
    echo "Building Docker image..."
    echo -e "${YELLOW}This may take a few minutes on first run...${NC}"
    echo ""
    
    if docker-compose -f docker-compose.mock.yml build; then
        echo ""
        echo -e "${GREEN}✓ Docker image built successfully${NC}"
    else
        echo ""
        echo -e "${RED}✗ Failed to build Docker image${NC}"
        exit 1
    fi
    
    # Start the container
    echo ""
    echo "Starting container..."
    
    if docker-compose -f docker-compose.mock.yml up -d; then
        echo ""
        echo -e "${GREEN}✓ Container started successfully${NC}"
    else
        echo ""
        echo -e "${RED}✗ Failed to start container${NC}"
        exit 1
    fi
fi

# Wait for container to be ready
echo ""
echo "Waiting for container to be ready..."
sleep 3

# Check if container is healthy
if docker-compose -f docker-compose.mock.yml ps | grep -q "Up"; then
    echo -e "${GREEN}✓ Container is running${NC}"
else
    echo -e "${RED}✗ Container failed to start${NC}"
    echo ""
    echo "Logs:"
    docker-compose -f docker-compose.mock.yml logs --tail=20
    exit 1
fi

# Display information
echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║                    Mock Mode Active                           ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${GREEN}Application is now running in mock mode!${NC}"
echo ""
echo "Access URLs:"
echo "  • Demo Page:  http://localhost:8000/mock-mode-demo.php"
echo "  • Main App:   http://localhost:8000"
echo ""
echo "Mock Mode Features:"
echo "  ✓ No MySQL database required"
echo "  ✓ No EVE SSO authentication"
echo "  ✓ No external API calls"
echo "  ✓ Auto-login with mock character"
echo ""
echo "Useful Commands:"
echo "  • View logs:   docker-compose -f docker-compose.mock.yml logs -f"
echo "  • Stop:        docker-compose -f docker-compose.mock.yml down"
echo "  • Restart:     docker-compose -f docker-compose.mock.yml restart"
echo "  • Shell:       docker-compose -f docker-compose.mock.yml exec pathfinder-mock bash"
echo ""
echo -e "${YELLOW}⚠ Warning: This is for development only. Do NOT use in production!${NC}"
echo ""
