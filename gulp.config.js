import packagefile from './package.json' assert {type: "json"};

try {

  var configFile = await import('./config.json', { assert: { type: "json" } });

} catch (ex) {

  configFile = {
    "default":{
      "dest": "./build"
    }
  };
}

var destinationFolder = (configFile.default.dest) + '/' + packagefile.name;


const buildConfig = {
  general: {
    dest: configFile.default.dest,
    package: packagefile,
  },
  sources: {
    sourceFolder: './src',
    allJsFiles: {
      front: './src/static/js/**/*.js',
      admin: './src/theme/admin/js/**/*.js',
    },
    allScssFiles: {
      front: './src/static/sass/main-files/**/*.scss',
      admin: './src/static/sass_admin/admin-style.scss',
      principalCSSFiles: './src/static/sass/style.scss'
    },
    allImgFiles: './src/static/images/**/*.{png,jpg,gif,svg}',
    allLibFiles: [
      //ChartJS
      './node_modules/chart.js/dist/chart.js',
      './node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js',
    ],
    vendorScripts: [
      './vendor/**/*'
    ],
    scaffolding: [
      'src/**/*',
      '!src/static/sass/**',
      '!src/static/sass_admin/**',
      '!src/static/js/**',
      '!src/admin/js/**',
      '!src/static/images/**'
    ],
    version: 'src/static/sass/variables-site/_version.scss',
    banner: [
      '/*!',
      'Theme Name: ' + packagefile.name,
      'Description:' + packagefile.description,
      'Author: ' + packagefile.author,
      'Version: ' + packagefile.version,
      'Tags: ' + (packagefile.keywords).join(' '),
      'Requires at least: 5.9.0',
      'Template: hello-elementor',
      '*/',
      ''
    ],
    email: './src/views/email/*',
    iconFont: './src/static/images/font-icons/*.svg',
  },
  destination: {
    destFolder: destinationFolder,
    allJsFiles: {
      front: destinationFolder + '/static/js/',
      admin: destinationFolder + '/theme/admin/js/',
    },
    allScssFiles: {
      front: destinationFolder + '/static/css/',
      admin: destinationFolder + '/static/css/',
    },
    allImgFiles: destinationFolder + '/static/images/',
    allLibFiles: destinationFolder + '/static/lib/',
    email: destinationFolder + '/views/email/',
    iconFont: destinationFolder + '/static/lib/fonts/',
    vendorScripts: destinationFolder + '/theme/vendor/',
    buildPackage: 'dist',
  }
};

export default buildConfig;
