---
title: Requirements
weight: 3
---

This package requires:
- PHP 8 or higher 
- For highlighting code: Node 10 or newer



#### Using Node Version Manager

Under the hood, this package runs a node command  to render the markdown. If you use NVM during development, 
then the package will be unlikely to find your version of node as it looks for the node executable in
`/usr/local/bin` and `/opt/homebrew/bin` - if this is the case, then you should create a symlink between
the node distributable in your NVM folder, to that of the `usr/local/bin`. Such a command might look like this:

```bash
sudo ln -s /home/some-user/.nvm/versions/node/v17.3.1/bin/node /usr/local/bin/node
```

Creating this symlink will allow the package to find your NPM executable. Please note, if you change
your NPM version you will have to update your symlinks accordingly.
