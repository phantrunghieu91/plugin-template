# Plugin Template

This is a template for creating plugins in your projects. It provides a basic structure and guidelines to help you get started quickly.

## Installation

To use this plugin template, follow these steps:

1. Clone the repository to your local machine.
2. Run composer install
3. Run pnpm install to install all required packages.
4. Change the plugin-template.php to be the same as folder name (Plugin name). You can also change the project name in composer.json and package.json if you want.

## Usage

To use the plugin, include the following code in your project:

```javascript
import Plugin from './plugin-template';

const plugin = new Plugin();
plugin.init();
```

## Contributing

Contributions are welcome! If you have any ideas, suggestions, or bug reports, please open an issue or submit a pull request.
