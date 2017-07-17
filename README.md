# clsrestapi
### Cloudy Logic Studios REST API

Welcome to the REST API source for Cloudy Logic Studios, hosted on [http://api.cloudylogic.com](http://api.cloudylogic.com). The information here should help you understand the REST implementation for the Cloudy Logic Studios app. If you have questions, or would like to provide feedback and/or to report a bug, feel free to contact the author, Ken Lowrie, at [www.kenlowrie.com](http://www.kenlowrie.com/).

### Attributions

Attributions here...

<a id="install">&nbsp;</a>

#### Installing this app to your server

This is a [Gulp](http://gulpjs.com/) project, so you'll need [Node.js](https://nodejs.org/en/) installed on your build machine in order to put the distribution together from the sources in an automated fashion. Follow the link above to learn about Gulp and how to set it up on your system, just make sure to install and configure Node.js first. 

> **NOTE**: There isn't much processing required for this app, so it's pretty straightforward if you want to skip the automated build portion and simply copy the sources to your web server. See the section on [manual installation](#manualinstall) for details.

Once you've installed Node.js, simply checkout the source tree from Github to a local directory on your system, and issue: "npm install" to automatically pull down the various Gulp modules you need to build a distribution.

Then, run "gulp" to build a development version, or "NODE_ENV=rel gulp" to build a release version (usually, the only difference is that your CSS and JS will be minified in the release version).

Running Gulp will create a "Build/dev" or "Build/rel" depending on how the NODE_ENV variable is set. Go into the corresponding directory, and then transfer all the files up to your server, maintaining the directory structure, and you'll be all set!

<a id="needapache">&nbsp;</a>
##### Special Note about Apache requirement

This code was built to run on Apache's web server, and relies on a feature in httpd in order to make it work, the .htaccess file. This file allows you to do some specialized processing by the web server, freeing me up front handling it in the code. In my case:

1. The ability to write an HTTP header into the responses, using this .htaccess entry: Header set Access-Control-Allow-Origin "*". This header makes the CLS REST API app CORS compliant, which basically allows you to do these API calls cross-domain. Very important, since my client apps will not be running in the cloudylogic.com domain. [On this page](https://enable-cors.org/server.html), you can read more about this, and also find out how to enable this on your web server, if you are not running Apache.

2. The URL rewriting feature, which allows me to breakdown the path and load the correct API handler. This is **important**. For example, if the client issues this request: GET http://api.cloudylogic.com/versions/reels/, the web server needs to break this down like this: http://api.cloudylogic.com/versions/index.php, because "reels/" is not an actual folder on the server. The PHP code in the "/versions/index.php" folder will handle parsing the parameters, in this case "reels/" as it's processing the request. This is done by parsing the original URI, which is one of the variables exposed by PHP.

If you are not using Apache, then you'll have to figure out how to implement something similar. Probably the easiest way I can think of would be to use query strings instead. For example, GET http://api.cloudylogic.com/versions/?parms=reels would be one way. Of course you'll have to modify the server to parse it out appropriately. Shouldn't be a big deal.

That's it! If you run into any problems, feel free to contact me for assistance.

#### Why a REST API for the Cloudy Logic App?

The original Cloudy Logic Studios app was written in Objective C for the iOS platform. For some time, I've been wanting to do an Android version of the app, as well as convert it to Swift for iOS. One of the biggest disadvantages to the original version is that it relied on hard-coded data for the embedded video content, as well as the contact information, etc. So anytime I want/need to change it, I have to rebuild the app and redeploy. This is not good.

So, I decided to use a more flexible method for handling this in the newer versions of the app, and this led me to separating the dynamic content into an API that I could easily access from any platform, in a consistent manner.

And thus was born the CLS REST API.

The server side of the API is contained in this repository, and the remainder of this document will describe it, document it, and hopefully explain everything you want or need to know about it.

#### The Implementation

The CLS REST API server side is written entire in PHP, and uses [JSON](http://www.json.org/) encoding to expose the data associated with each API call. The APIs available are:

1. [versions](#versions) - Returns the versions of a specific (or all) API. 
2. [about-us](#about-us) - Returns a text description of what Cloudy Logic Studios does.
3. [contact-info](#contact-info) - Returns contact information for Cloudy Logic.
4. [reels](#reels) - Returns information about demo reels including a streaming URL.
5. [our-work](#our-work) - Returns information about select video projects that showcase the company.

In the following section, I'll go over each of the APIs, what they return, and how to use them.

<a id="versions">&nbsp;</a>
#### http://api.cloudylogic.com/versions/ [apiname/]

The /versions API returns an array of objects that describe the implemention and data version for each of the CLS REST APIs. 

##### Examples
[http://api.cloudylogic.com/versions/](http://api.cloudylogic.com/versions/) - Returns version data for all APIs

[http://api.cloudylogic.com/versions/reels/](http://api.cloudylogic.com/versions/reels/) - Returns version data for the /reels API only

The intent behind this API is to indicate to a client that has cached prior return data whether or not there is any need to request an update, or if it's okay to simply use the locally cached data.

e.g. If my app wants to display the latest demo reel for Cloudy Logic, and I've previously downloaded the demo reel data via the ***/reels*** API, as long as the current data version for **/reels** is the same as what is was when I originally downloaded it, there is no need for me to re-request the demo reel information. Instead, I can simply play the demo reel using the URL I already have cached locally.

<a id="about-us">&nbsp;</a>
#### http://api.cloudylogic.com/about-us/

The /about-us API returns a text description for Cloudy Logic Studios. 

##### Examples
[http://api.cloudylogic.com/about-us/](http://api.cloudylogic.com/about-us/) - Returns information about Cloudy Logic

The intent behind this API is to .

<a id="contact-info">&nbsp;</a>
#### http://api.cloudylogic.com/contact-info/

The /contact-info API returns an array of contact information for Cloudy Logic Studios. 

##### Examples
[http://api.cloudylogic.com/contact-info/](http://api.cloudylogic.com/contact-info/) - Returns contact information for Cloudy Logic

##### Sample Return Data

<pre>
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/contact-info/",
    "query_string": null,
    "restAPIkeys": [
      "contact-info"
    ]
  },
  "apiVer": {
    "apiName": "contact-info",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
    "location": "Cloudy Logic Studios is located between San Antonio and Austin Texas.",
    "address": {
      "name": "Cloudy Logic Studios",
      "street": "123 Anystreet",
      "city": "Any Town",
      "state": "TX",
      "zipcode": "12345"
    },
    "email": "info@cloudylogic.com",
    "phone": "512.555.1234",
    "socialNetworks": [
      {
        "network": "Facebook",
        "id": "cloudylogic",
        "url": "https://www.facebook.com/cloudylogic"
      },
      {
        "network": "Twitter",
        "id": "cloudylogic",
        "url": "https://twitter.com/cloudylogic"
      },
      {
        "network": "Vimeo",
        "id": "cloudylogic",
        "url": "https://vimeo.com/cloudylogic"
      }
    ]
  }
}
</pre>

This API returns the contact information for the business. This includes the typical data, such as mailing address, phone and email, as well as the various social media contacts.

<a id="reels">&nbsp;</a>
#### http://api.cloudylogic.com/reels/ [ID#/]

The /reels API returns information about one or all demo reels for Cloudy Logic Studios. If the optional [ID#] is supplied, then the information for that specific demo reel is returned instead. If the ID number provided is invalid, then information about all demo reels is returned.

> **NOTE** An ID of 0 always refers to the "latest" or newest demo reel. 1 refers to the second latest demo reel, and so on.

##### Examples

To return information for all Cloudy Logic demo reels:
<pre>[http://api.cloudylogic.com/reels/](http://api.cloudylogic.com/reels/)</pre>

To return information for the latest Cloudy Logic demo reel:
<pre>[http://api.cloudylogic.com/reels/0/](http://api.cloudylogic.com/reels/0/)</pre>

To return information for the second latest Cloudy Logic demo reel:
<pre>[http://api.cloudylogic.com/reels/1/](http://api.cloudylogic.com/reels/0/)</pre>

##### Sample Return Data

<pre>
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/reels/",
    "query_string": null,
    "restAPIkeys": [
      "reels"
    ]
  },
  "apiVer": {
    "apiName": "reels",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
    "numReels": 5,
    "reelList": [
      {
        "title": "Cloudy Logic Demo Reel",
        "url": "https://vimeo.com/176516244",
        "sUrl": "http://player.vimeo.com/external/176516244.m3u8?p=high,standard,mobile&s=vimeoSID",
        "thumb": "thumbnail",
        "frame": "image-frame"
      },
      {
        "title": "Cloudy Logic Demo Reel 2014",
        "url": "https://vimeo.com/81617741",
        "sUrl": "http://player.vimeo.com/external/81617741.m3u8?p=high,standard,mobile&s=vimeoSID",
        "thumb": "thumbnail",
        "frame": "image-frame"
      },
      {
        "title": "Cloudy Logic Demo Reel 2011",
        "url": "https://vimeo.com/20914693",
        "sUrl": "http://player.vimeo.com/external/20914693.m3u8?p=high,standard,mobile&s=vimeoSID",
        "thumb": "thumbnail",
        "frame": "image-frame"
      },
      {
        "title": "Cloudy Logic Demo Reel 2010",
        "url": "https://vimeo.com/12920154",
        "sUrl": "http://player.vimeo.com/external/12920154.m3u8?p=high,standard,mobile&s=vimeoSID",
        "thumb": "thumbnail",
        "frame": "image-frame"
      },
      {
        "title": "Cloudy Logic Demo Reel 2009",
        "url": "https://vimeo.com/8476572",
        "sUrl": "http://player.vimeo.com/external/8476572.m3u8?p=high,standard,mobile&s=vimeoSID",
        "thumb": "thumbnail",
        "frame": "image-frame"
      }
    ]
  }
}
</pre>

<a id="our-work">&nbsp;</a>
#### http://api.cloudylogic.com/our-work/ [ID#/]

The /our-work API returns an array of objects that describe videos which showcase some of Cloudy Logic Studios' past projects. It can also return more detailed information on a specific video, if it's ID is passed in. 

##### Examples
[http://api.cloudylogic.com/our-work/](http://api.cloudylogic.com/our-work/) - Returns information about showcased Cloudy Logic past projects.

The intent behind this API is to .

#### Additional Information

Talk about looking at the source code for additional information.

Talk about reviewing the test code written in Java
Talk about reviewing client code for Python, Java, Kotlin, Javascript and Swift

Take a look at the [index.php](https://github.com/kenlowrie/clsrestapi/blob/master/src/index.php) in the root of this project to see the JavaScript AJAX code that is used to invoke the API when the buttons are pressed. It's part of the manual testing code built-in to the server side of the code, allowing me to quickly test any changes, as well as providing a valuable debug tool for developing client apps that process the JSON return data.

You may want to check out the Python test code for the CLS REST API, that repository, called [testclsrest](https://github.com/kenlowrie/testclsrest) is also available on [GitHub](https://github.com/).

<a id="manualinstall">&nbsp;</a>
#### Manual installation

If you would like to manually install this code on your server or development machine, follow these instructions and hope for the best! Just kidding, it's pretty straightforward, and I'll try to keep this up to date if things change, but I can't make any promises on that. In other words, you might need to put on your debug hat if the instructions do not work. :)

1. .htaccess - If you're on Apache, copy the .htaccess to the "root" where you are going to install this app. Probably NOT, the root directory of the web server, but some directory below it. Note that this application is written for the Apache web server (httpd), and relies on the .htaccess feature to work. Read about this in the [Installing this app ...](#needapache) section of the readme.

2. index.php - Copy this file into the directory where you are installing everything else. It should be in the same directory as .htaccess.

3. about-us/* - Copy this folder, keeping it intact. It has the code for processing the 'about-us' API.

4. contact-info/* - Copy this folder, keeping it intact. You see where this is going, right? ...

5. our-work/* - Copy this folder, keeping it intact.

6. reels/* - Copy this folder, keeping it intact.

7. versions/* - Copy this folder, keeping it intact.

8. includes/* - Copy this folder, keeping it intact. This has the common code used by all the APIs.

9. css/* - Copy this folder, keeping it intact. This is the CSS used to style the root index.php HTML.

That should be it. Good luck!

#### What's Next?

Now that this API is [up and running](http://api.cloudylogic.com/), a [client test script](https://github.com/kenlowrie/testclsrest) is available, the next steps are to create some clients to utilize the API.

As I mentioned at the outset, the original intention was to separate the hard-coded data from my iOS app, so that'll definitely be one of the things coming up. However, I think the first thing I'm gonna do is create a JAVA client, to help me make sure the API will be usable in practice, and an added benefit that it'll be the core needed to create an Android app for the Play store.

I will, of course, be publishing the source for all the clients here on [GitHub](https://github.com/), and as soon as the first one is ready, I'll add a new repository and put the link right in here.

I hope that you've found this project useful, and as always, if you have any questions, please feel free to contact me at [www.kenlowrie.com](http://www.kenlowrie.com/).

#### Summary

This concludes the documentation on the CLS REST API server side code.
