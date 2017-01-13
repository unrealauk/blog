**Install node js**

`curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -`

`sudo apt-get install -y nodejs`

**Install gulp cli**

`sudo npm install gulp-cli --global`
***
**Install dependencies**

`npm install`
***
**Base settings:**

  `root: '.styles'` root directory.

  `scss: '.styles/sass/*.scss'` scss directory.

  `css: '.styles/css'` css directory.
  
  `watch: './styles/sass/*/*.scss'` gulp watch directory.

  `browsers = 'Last 3 versions'` list of browsers, which are supported in your project.

   `proxy: 'example.loc'` site url. Required for live-reload.
***
**Available commands:**

- `gulp dev` compile Sass stylesheets to CSS for developers. Contain better output style for reading.

- `gulp prod` compile Sass stylesheets to minifed CSS styles for prod.

- `gulp` run in development mode with enabled live-reload mode. Looks like `gulp dev`

- `gulp watch` compile Sass stylesheets to CSS when they change
***

You don't need a chrome extension LiveReload.
