# clsrestapi
### Cloudy Logic Studios REST API

Welcome to the REST API source for Cloudy Logic Studios, hosted on [http://api.cloudylogic.com](http://api.cloudylogic.com). The information here should help you understand the REST implementation for the Cloudy Logic Studios domain. If you have questions, or would like to provide feedback and/or to report a bug, feel free to contact the author, Ken Lowrie, at [www.kenlowrie.com](http://www.kenlowrie.com/).

#### Attributions

Attributions here...

<a id="install">&nbsp;</a>

### Installing this app to your server

This is a [Gulp](http://gulpjs.com/) project, so you'll need [Node.js](https://nodejs.org/en/) installed on your build machine in order to put the distribution together from the sources in an automated fashion. Follow the link above to learn about Gulp and how to set it up on your system, just make sure to install and configure Node.js first. 

> **NOTE**: There isn't much processing required for this app, so it's pretty straightforward if you want to skip the automated build portion and simply copy the sources to your web server. See the section on [manual installation](#manualinstall) for details.

Once you've installed Node.js, simply checkout the source tree from Github to a local directory on your system, and issue: "npm install" to automatically pull down the various Gulp modules you need to build a distribution.

Then, run "gulp" to build a development version, or "NODE_ENV=rel gulp" to build a release version (usually, the only difference is that your CSS and JS will be minified in the release version).

Running Gulp will create a "Build/dev" or "Build/rel" depending on how the NODE_ENV variable is set. Go into the corresponding directory, and then transfer all the files up to your server, maintaining the directory structure, and you'll be all set!

<a id="needapache">&nbsp;</a>
#### Special Note about Apache requirement

This code was built to run on Apache's web server, and relies on a feature in httpd in order to make it work, the .htaccess file. This file allows you to do some specialized processing by the web server, freeing me up front handling it in the code. In my case:

1. The ability to write an HTTP header into the responses, using this .htaccess entry: Header set Access-Control-Allow-Origin "*". This header makes the CLS REST API [CORS](https://www.w3.org/TR/cors/) compliant, which basically allows you to do these API calls cross-domain. **Very important**, since my client apps will not be running in the cloudylogic.com domain. [On this page](https://enable-cors.org/server.html), you can read more about this, and also find out how to enable this on your web server, if you are not running Apache. You could also implement it in the code by writing the header yourself. I am already writing the "Content-Type: application/json" header, so look for that, and just add the line there instead if you can't find an easier way. Or perhaps you do NOT want your REST API to allow cross origin calls, in which case stop reading this now, and be sure to delete that line from the .htaccess if you are using Apache's httpd web server.

2. The URL rewriting feature, which allows me to breakdown the path and load the correct API handler. This is **important**. For example, if the client issues this request: <code>GET http://api.cloudylogic.com/versions/reels/</code>, the web server needs to rewrite this URL like this: <code>http://api.cloudylogic.com/versions/index.php</code>, because "reels/" is not an actual folder on the server, and so the GET request will fail. The PHP code in the "versions/index.php" folder will handle parsing the parameters, in this case "reels/" as it's processing the request. This is done by parsing the original URI, which is one of the variables exposed by PHP.

If you are not using Apache, then you'll have to figure out how to implement something similar. Probably the easiest way I can think of would be to use query strings instead. For example, GET http://api.cloudylogic.com/versions/?parms=reels would be one way. Of course you'll have to modify the server to parse it out appropriately. Shouldn't be a big deal.

That's it! If you run into any problems, feel free to contact me for assistance.

### Why a REST API for the Cloudy Logic App?

The original Cloudy Logic Studios app was written in Objective C for the iOS platform. For some time, I've been wanting to do an Android version of the app, as well as convert it to Swift for iOS. One of the biggest disadvantages to the original version is that it relied on hard-coded data for the embedded video content, as well as the contact information, etc. So anytime I want/need to change it, I have to rebuild the app and redeploy. This is not good.

So, I decided to use a more flexible method for handling this in the next version of the app, and this led me to separating the dynamic content into an API that I could easily access from any platform, in a consistent manner.

And thus was born the CLS REST API.

The server side of the API is contained in this repository, and the remainder of this document will describe it, document it, and hopefully explain everything you want or need to know about it.

#### The Implementation

The CLS REST API server side is written entire in PHP, and uses [JSON](http://www.json.org/) encoding to expose the data associated with each API call. The APIs available are:

1. [versions](#versions) - Returns the versions of a specific (or all) API. 
2. [about-us](#about-us) - Returns a text description of what Cloudy Logic Studios does.
3. [contact-info](#contact-info) - Returns contact information for Cloudy Logic.
4. [reels](#reels) - Returns information about demo reels including a streaming URL.
5. [our-work](#our-work) - Returns information about select video projects that showcase the company.

The API is designed to be called as a standard HTTP GET request. On my server, I created a subdomain, called [api.cloudylogic.com](http://api.cloudylogic.com). That subdomain has a document root of /api in my web servers data directory. Not that any of that matters per se, but in the interest of explaining how I set things up, it's here.

So, any client can issue an HTTP GET request in this format:

<code>GET http://api.cloudylogic.com/apiname/</code>

And the API *apiname* will be invoked (assuming that *apiname* is a valid name). In my case, it isn't, so be sure you use one of the names I've listed above instead.

Parameters can be passed by tacking on additional data to the URL. For example, say I want to find out the version of the **reels** API. I could issue this request:

<code>GET http://api.cloudylogic.com/versions/reels/</code>

And the *versions* API would be invoked, it would see that you are wanting the version for the *reels* API only, so it would return that to you. Here's an actual link you can click on which will invoke that prior API for you, so you can see exactly what it returns:

<code>[http://api.cloudylogic.com/versions/reels/](http://api.cloudylogic.com/versions/reels/)</code>

The JSON data returned by each API has the following format:

<pre>
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/versions/",
    "query_string": null,
    "restAPIkeys": [
      "versions"
    ]
  },
  "apiVer": {
    "apiName": "versions",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
  }
}
</pre>

There are three (3) primary objects that are always at the root level, and all but ***apiObj*** have the same data elements present. 

***dbgObj*** provides some generic information about the API request, including the request_uri, and whether or not it was successfully parsed. The array ***restAPIkeys*** contains the elements of the path string, after the domain name.

***apiVer*** contains the version information for the API request. This includes the name of the API in ***apiName***, the internal version in ***apiVersion***, and what I refer to as the Data Version, in ***apiDataVersion***. The design concept is that ***apiVersion*** will change if the API itself changes, for example if new elements are returned, or any are removed [gasp]. ***apiDataVersion*** on the other hand, would change if the data inside ***apiObj*** changed only. For example, say a new demo reel is added, the *data* returned by the *reels* API would now be different, so I would change the ***apiDataVersion***. A client program that had cached the reel data from a previous call could easily detect that there is new data present, so it would need to request the latest version.

***apiObj*** contains the API-specific return data, and is different for each API. Refer to the specific API documentation below to determine what you can expect to be returned in this object for that specific API.

And that's about all there is to the implementation of the CLS REST API. In the sections that follow, I'll go over each one of the APIs, what they return, and how to use them.

<a id="versions">&nbsp;</a>
### API: versions

#### http://api.cloudylogic.com/versions/ [apiname/]

The *versions* API returns an array of objects that describe the implemention and data version for each of the CLS REST APIs. 

##### Examples
To return version data for all APIs:
<code>[http://api.cloudylogic.com/versions/](http://api.cloudylogic.com/versions/)</code>

To return version data for the *reels* API only:
<code>[http://api.cloudylogic.com/versions/reels/](http://api.cloudylogic.com/versions/reels/)</code>

##### Sample Return Data

<pre>
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/versions/",
    "query_string": null,
    "restAPIkeys": [
      "versions"
    ]
  },
  "apiVer": {
    "apiName": "versions",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
    "numApis": 5,
    "apiList": [
      {
        "apiName": "versions",
        "apiVersion": "1.0",
        "apiDataVersion": "1.0"
      },
      {
        "apiName": "reels",
        "apiVersion": "1.0",
        "apiDataVersion": "1.0"
      },
      {
        "apiName": "about-us",
        "apiVersion": "1.0",
        "apiDataVersion": "1.0"
      },
      {
        "apiName": "contact-info",
        "apiVersion": "1.0",
        "apiDataVersion": "1.0"
      },
      {
        "apiName": "our-work",
        "apiVersion": "1.0",
        "apiDataVersion": "1.0"
      }
    ]
  }
}
</pre>

The intent behind the *versions* API is to indicate to a client that has cached prior return data whether or not there is any need to request an update, or if it's okay to simply use the locally cached data. For example, If my app wants to display the latest demo reel for Cloudy Logic, and I've previously downloaded the demo reel data via the *reels* API, as long as the current data version for *reels* is the same as what is was when I originally downloaded it, there is no need for me to re-request the demo reel information. Instead, I can simply play the demo reel using the URL I already have cached locally.

<a id="about-us">&nbsp;</a>
### API: about-us

#### http://api.cloudylogic.com/about-us/

The *about-us* API returns a text description for Cloudy Logic Studios. 

##### Examples
To return some background information about Cloudy Logic:
<code>[http://api.cloudylogic.com/about-us/](http://api.cloudylogic.com/about-us/)</code>

##### Sample Return data

<pre>
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/about-us/",
    "query_string": null,
    "restAPIkeys": [
      "about-us"
    ]
  },
  "apiVer": {
    "apiName": "about-us",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
    "aboutus": "Although Cloudy Logic wasn't officially formed until 2004, we have been creating all types of media content since the late 1990′s. With over 30 years of combined experience, you can be certain that we can create exactly what you’re looking for. Let us help you take your idea from concept to completion, whether it’s a business profile, narrative film, commercial, music video or documentary. Or, if you already have your concept, we can simply provide production and/or post-production services. Whatever your needs are, we are eager to help you achieve them. Go ahead and give us a call at 512-555-1234 or email us at spam@cloudylogic.com for more information or to get a quote for your project."
  }
}
</pre>

This API is used to return information about the company, suitable for display on the "About Us" page of a website, or inside a client application.

<a id="contact-info">&nbsp;</a>
### API: contact-info

#### http://api.cloudylogic.com/contact-info/

The *contact-info* API returns an array of contact information for Cloudy Logic Studios. 

##### Examples
To return the contact information for Cloudy Logic:
<code>[http://api.cloudylogic.com/contact-info/](http://api.cloudylogic.com/contact-info/)</code>

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
    "email": "spam@cloudylogic.com",
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

This API returns the contact information for the business. This includes the typical data, such as mailing address, phone and email, as well as the various social media contacts. A webpage might display this information on the "Contact" page, or a client application could use it to request information and/or support.

<a id="reels">&nbsp;</a>
### API: reels

#### http://api.cloudylogic.com/reels/ [ID#/]

The *reels* API returns information about one or all demo reels for Cloudy Logic Studios. If the optional [ID#] is supplied, then the information for that specific demo reel is returned instead. If the ID number provided is invalid, then information about all demo reels is returned.

> **NOTE** An ID of 0 always refers to the "latest" or newest demo reel. 1 refers to the second latest demo reel, and so on.

##### Examples

To return information for all Cloudy Logic demo reels:
<code>[http://api.cloudylogic.com/reels/](http://api.cloudylogic.com/reels/)</code>

To return information for the latest Cloudy Logic demo reel:
<code>[http://api.cloudylogic.com/reels/0/](http://api.cloudylogic.com/reels/0/)</code>

To return information for the second latest Cloudy Logic demo reel:
<code>[http://api.cloudylogic.com/reels/1/](http://api.cloudylogic.com/reels/1/)</code>

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

This API could be used to display a table of demo reels for the company, or perhaps to just display the latest demo reel. In the original iOS app for Cloudy Logic Studios, the main tab of the application had the demo reel video window, along with buttons that would take the user to the various social media sites. To implement this same functionality using the CLS REST API, you could call the *reels/0/* API and the *contact-info/* API, and use the returned data to dynamically build a page with that content on it.

<a id="our-work">&nbsp;</a>
### API: our-work

#### http://api.cloudylogic.com/our-work/ [ID#/]

The *our-work* API returns an array of objects that describe videos which showcase some of Cloudy Logic Studios' past projects. It can also return more detailed information on a specific video, if it's ID is passed in.

>**NOTE**: In the current implementation, there is no difference between the data returned in ***apiObj*** for all showcase videos versus a single video. I plan to make the determination of whether that makes sense when I implement that tab in the new client application, so it could change in the future.

##### Examples
To return information about showcased Cloudy Logic past projects:
</code>[http://api.cloudylogic.com/our-work/](http://api.cloudylogic.com/our-work/)</code>

##### Sample Return data

This JSON return data was obtained using GET http://api.cloudylogic.com/our-work/3/. I didn't want to show the return data from all showcase videos, due to the amount of data that was returned.

<pre>
reset
{
  "dbgObj": {
    "traceMsgQ": [],
    "parseOK": true,
    "request_uri": "/our-work/3/",
    "query_string": null,
    "restAPIkeys": [
      "our-work",
      "3"
    ]
  },
  "apiVer": {
    "apiName": "our-work",
    "apiVersion": "1.0",
    "apiDataVersion": "1.0"
  },
  "apiObj": {
    "numVideos": 1,
    "videoList": [
      {
        "type": "Live Performance Multi-Camera",
        "roles": {
          "director": "Ken Lowrie",
          "dp": "",
          "camera": "Ken Lowrie & Brenda Lowrie",
          "editor": "Ken Lowrie & Brenda Lowrie"
        },
        "description": "Multi-Camera music videos capture another element of the performance. These high-end productions are styled to fit the music and the artist and involve plenty of pre-production to be sure that the final product matches the original concept. Here’s a simple multi-cam shoot we did for Philip R. Bonanno’s “Have Yourself A Merry Little Christmas” performance inside the Cloudy Logic Studios Florida Complex. Give us a call and we can discuss ideas and options! (Original music by Hugh Martin, lyrics by Ralph Blane)",
        "title": "Have Yourself A Merry Little Christmas",
        "url": "https://vimeo.com/56170832",
        "sUrl": "http://player.vimeo.com/external/56170832.m3u8?p=high,standard,mobile&s=5f8d87f055bf1957b7540b3b9d22eb40",
        "thumb": "imglive",
        "frame": "frxmas"
      }
    ]
  }
}
</pre>

The intent behind this API is to provide a client with a list of videos that showcase the company's past projects. That data could be used to construct a table with thumbnails and short descriptions, perhaps using the *type* data element, and then if the user selects that row, a subsequent page could display the video along with the long description and a credits list by using the roles for the project.

### Additional Information

The PHP source code is fully documented, and I will add more details later as I get any specific questions about the code. Please feel free to sent comments and suggestions to me so I can improve not only the documentation in the source, but this user guide as well.

Take a look at the [index.php](https://github.com/kenlowrie/clsrestapi/blob/master/src/index.php) in the root of this project to see the JavaScript AJAX code that is used to invoke the API when the buttons are pressed. It's part of the manual testing code built-in to the server side of the code, allowing me to quickly test any changes, as well as providing a valuable debug tool for developing client apps that process the JSON return data.

You may want to check out the Python test code for the CLS REST API, that repository, called [testclsrest](https://github.com/kenlowrie/testclsrest) is also available on [GitHub](https://github.com/).

<a id="manualinstall">&nbsp;</a>
### Manual installation

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

### What's Next?

Now that this API is [up and running](http://api.cloudylogic.com/), a [client test script](https://github.com/kenlowrie/testclsrest) is available, the next steps are to create some clients to utilize the API.

As I mentioned at the outset, the original intention was to separate the hard-coded data from my iOS app, so that'll definitely be one of the things coming up. However, I think the first thing I'm gonna do is create a JAVA client, to help me make sure the API will be usable in practice, and an added benefit that it'll be the core needed to create an Android app for the Play store.

I will, of course, be publishing the source for all the clients here on [GitHub](https://github.com/), and as soon as the first one is ready, I'll add a new repository and put the link right in here. My current thinking will be to create clients in the following languages (not in any particular order, except for Java):

1. [Java Class Library](https://github.com/kenlowrie/java-clsrestapi) &amp; &lt;[Command Line App](https://github.com/kenlowrie/jclCLSrest) - **Done on 8/27/2017!**&gt;
2. Java Client - A reference client for macOS and Windows systems
3. Java Android Client - an Android-specific client, hopefully on the play store
3. JavaScript - A responsive webapp client 
4. Python - Not real sure about this one yet...
5. Swift Class Library
5. Swift - iOS and possibly macOS versions and even less possibly at tvOS version
6. Kotlin - another Android client, also hopefully on the play store


I hope that you've found this project useful, and as always, if you have any questions, please feel free to contact me at [www.kenlowrie.com](http://www.kenlowrie.com/).

### Summary

This concludes the documentation on the CLS REST API server side code.
