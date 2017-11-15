## Frontend
Grunt tool is used for css & js developments. As suggested on Magento docs:

* [http://devdocs.magento.com/guides/v2.0/frontend-dev-guide/css-topics/css_debug.html](http://devdocs.magento.com/guides/v2.0/frontend-dev-guide/css-topics/css_debug.html)

In order to use this tool do the following:

### Installation

#### 1. First install npm

**Mac**:

* `$ brew install npm`

**Ubuntu**:

* `$ sudo apt-get install npm`

**Other**:

In case that the previous methods do not work for you, follow the node.js documentation.

* [install node.js & npm](https://docs.npmjs.com/getting-started/installing-node)

#### 2. Install grunt

* First Install grunt-cli:

    * `$ npm install -g grunt-cli`

* Second Install bower globally

    * `$ npm install -g bower`

* Third Install the project dependencies:

    * `$ cd <magento_dir>`
    
    * Setup package.json `cp package.json.sample package.json`
    
    * Setup Gruntfile.js `cp Gruntfile.js.sample Gruntfile.js`

    * `$ npm install`

    * `$ npm update`


### Usage

Once npm and grunt are installed for your project, you can compile the static content in one of the following ways:

This actions must be executed inside the magento folder `cd <magento_dir>`

* Removes the theme related static files in the pub/static and var directories.
    
    * `grunt clean:<theme>`

* Republishes symlinks to the source files to the pub/static/frontend/<Vendor>/<theme>/<locale> directory. 

    * `grunt exec:<theme>`

* Compiles .css files using the symlinks published in the pub/static/frontend/<Vendor>/<theme>/<locale> directory 
 
    * `grunt less:<theme>`

* **Watch & compile dynamically while you change css/js files:**

    * `grunt watch`
    
    * (Optional) If you want to use Grunt for "watching" changes automatically, without reloading pages in a browser each time, install the [LiveReload](http://livereload.com/extensions/) extension in your browser.
    
**Notes:**

* It is only possible to update one locale on theme.js. If you want to check the changes in another locale, you can execute this command:

    * `bin/magento setup:static-content:deploy <locale>`