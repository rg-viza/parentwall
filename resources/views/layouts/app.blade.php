<!DOCTYPE html>
<html>
    <head>
        <title>ParentWall</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
		background-image: url("/images/linen.jpg");
                height: 100%;
            }
	* {
		text-shadow: 2px 2px #333333;
		font-family: inherit;
		font-weight: inherit;
		font-style: inherit;
		font-size: inherit;
		line-height: inherit;
		text-align: inherit;
		color: inherit;
		text-decoration: none;
		list-style: none;
		margin: 0;
		padding: 0;
		border: 0;
		box-sizing: border-box;
	}
	body {
		font-family: "Lato", Verdana, sans-serif;
		font-weight: bold;
		font-size: .875em;
		line-height: 1;
		margin-top: 2em;
		text-align: left;
		color: #fff;
		-webkit-text-size-adjust: 100%;
		font-kerning: normal;
		-moz-font-feature-settings: "kern","ss01","ss02";
		-webkit-font-feature-settings: "kern","ss01","ss02";
		font-feature-settings: "kern","ss01","ss02";
	}
/* The mobile first, breakpoint without any media queries, sets up the body:before layout */
	body:before { /* BREAKPOINT INDICATOR */
  		content: 'XXS';
  		font-family: 'Lato', Verdana, sans-serif;
                font-weight: bold;
  		font-size: 9px;
  		color: rgba(128,128,128, 0.5);
  		position: fixed;
  		top: 0px;
  		left: 0px;
  		display: none;
  		z-index: 10000;
	}
/*
        body {
                margin: 0;
                padding: 0;
                width: 1080px;
                display: table;
                font-family: 'Lato';
        }
*/

	@media (min-width: 20em) {
		body:before {content: 'XS';}
	}
	@media (min-width: 30em) {
		body:before {content: 'S';}
	}
	@media (min-width: 36em) {
		body:before {content: 'S/M';}
	}
	@media (min-width: 48em) {
		body:before {content: 'M';}
	}
	@media (min-width: 64em) {
		body:before {content: 'L';}
	}
	@media (min-width: 80em) {
		body:before {content: 'XL';}
	}
	@media (min-width: 96em) {
		body:before {content: 'XXL';}
	}
        .container {
		text-align: center;
                display: fixed;
                vertical-align: middle;
        }

        .content {
                text-align: center;
                display: inline-block;
        }
	.status {
		text-align: center;
		display: block;
	}
	.statuscontainer {
		font-size: 2em;
		width: 12em;
	}
	.statustitle {
		padding: .75em;
		width: 12em;
	}
	.statustitle span {
		float: left;
	}
	.statustitle input[type=text],input[type=email],input[type=password] {
		float: right;
		display: block;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		clear;
	}
	.status {
		text-shadow: 3px 3px #333333;
		float: right;
		display: inline-block;
	}
	.title {
		font-size: 2em;
	}
	.title span {
		font-size:.5em;
	}
        .error span {
                font-size:.5em;
                color: yellow;
        }
	input[type=submit] {
		padding:15px; 
		background:#666; 
		border:0 none;
		cursor:pointer;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		font-size: .75em;
	}
	input[type=email], input[type=password] {
		text-shadow: 1px 1px #333333;
		width: 5em;
		font-size: .75em;
		color: #999;
	}
        </style>
    </head>
    <body>
        <div class="container">
		<div class="content">
		@yield('content')
		</div>
	 </div>
    </body>
</html>
