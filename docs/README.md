# HumHub Gravatar Module

This module integrates [Gravatar](https://gravatar.com) with HumHub, providing users with automatic profile images based on their email addresses when they don't have a custom profile picture.

## Features

- Automatically uses Gravatar as fallback for user profile images
- Configurable default style (identicon, monsterid, wavatar, retro, robohash, blank)
- Configurable content rating filter (G, PG, R, X)
- Admin panel for easy configuration
- Compatible with HumHub 1.8 and above

## Installation

### Via Marketplace

1. Go to your HumHub Admin Panel
2. Navigate to the Marketplace
3. Search for "Gravatar"
4. Click "Install"

## Configuration

1. Go to Administration -> Modules -> Gravatar
2. Configure the default style and rating settings
3. Save your changes

## How It Works

The module works by hooking into HumHub's profile image display system:

1. When a user does not have a custom profile image, the module fetches their Gravatar based on their email address
2. If the user doesn't have a Gravatar account, the default style configured in the admin panel is used
3. All images respect the maximum content rating set in the configuration

## Requirements

- HumHub 1.8+
- PHP 7.4+

## Credits

- Gravatar is a service provided by Automattic Inc.
- Module development by Green Meteor