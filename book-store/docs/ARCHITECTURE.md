# System Architecture

## Overview

BookHaven is designed using a modular architecture that separates concerns between frontend, backend, and database layers. This document outlines the system's architecture, components, and their interactions.

## Architecture Diagram

```mermaid
graph TD
    A[Client Browser] -->|HTTP/HTTPS| B[Web Server]
    B -->|PHP| C[Application Layer]
    C -->|PDO| D[MySQL Database]
    C -->|File System| E[Asset Storage]
    F[Admin Dashboard] -->|PHP| C
```

## Components

