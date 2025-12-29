const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
	mode: "development",
	watch: true,
	
	entry: { 
	  main: './js/main.js' ,
	  css: './css/main.scss'
	},

	output: {
	  path: path.resolve(__dirname, 'assets/npm'),
	  filename: '[name].js',
		libraryTarget: 'var',
		library: '_initPawtucketApps'
	},
	resolve: {
    	modules: [
    		path.resolve(__dirname, 'js'),
    		path.resolve('../default/js'),	// include JS from default theme
    		path.resolve('../default/css'),	// include CSS from default theme
    		path.resolve('./node_modules'),
    	],
		alias: {
			themeJS: path.resolve(__dirname, "js"),			// path to theme JS
			defaultJS: path.resolve(__dirname, "../default/js"),		// path to default JS
			themeCSS: path.resolve(__dirname, "css"),		// path to theme CSS
			defaultCSS: path.resolve(__dirname, "../default/css")		// path to default CSS
		}
  	},
  module: {
    rules: [
      {
        test: /\.html$/,
        use: [
          {
            loader: "html-loader"
          }
        ]
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader']
      },
      {
        test: /\.scss$/,
        use: ['style-loader', 'css-loader', 'sass-loader']
      },
      { 
      	test: /\.(png|svg|gif)$/, 
        use: [{
            loader: "url-loader",
            options: { "limit": 100000 }
        }]
      },
      {
		test: /\.(woff|woff2|eot|ttf|otf)$/i,
		type: "asset/inline",
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    })
  ],
  externals: {
     pawtucketUIApps: 'pawtucketUIApps',
  }
};
