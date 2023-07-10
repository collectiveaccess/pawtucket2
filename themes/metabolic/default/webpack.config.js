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
	  path: path.resolve(__dirname, 'assets'),
	  filename: '[name].js'
	},
  module: {
    rules: [
	  {
		test: require.resolve('react'),
		use: [{
			loader: 'expose-loader',
			options: 'React'
	  	}],
	  },
	  {
		test: require.resolve('react-dom'),
		use: [{
			loader: 'expose-loader',
			options: 'ReactDOM'
	  	}],
	  },
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: { "presets": ["@babel/preset-env", "@babel/preset-react"] }
        }
      },
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
