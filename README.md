# clsrestapi
### Cloudy Logic Studios REST API

Welcome to the REST API source for Cloudy Logic Studios, hosted on [http://api.cloudylogic.com](http://api.cloudylogic.com). The information here should help you understand the REST implementation for the Cloudy Logic Studios app. If you have questions, or would like to provide feedback and/or to report a bug, feel free to contact the author, Ken Lowrie, at [www.kenlowrie.com](http://www.kenlowrie.com/).

### Attributions

Attributions here...

#### Installing this app to your server

This is a [Gulp](http://gulpjs.com/) project, so you'll need [Node.js](https://nodejs.org/en/) installed on your build machine in order to put the distribution together from the sources in an automated fashion. Follow the link above to learn about Gulp and how to set it up on your system, just make sure to install and configure Node.js first. 

> **NOTE**: There isn't much processing required for this app, so it's pretty straightforward if you want to skip the automated build portion and simply copy the sources to your web server.

Once you've installed Node.js, simply checkout the source tree from Github to a local directory on your system, and issue: "npm install" to automatically pull down the various Gulp modules you need to build a distribution.

Then, run "gulp" to build a development version, or "NODE_ENV=rel gulp" to build a release version (usually, the only difference is that your CSS and JS will be minified in the release version).

Running Gulp will create a "Build/dev" or "Build/rel" depending on how the NODE_ENV variable is set. Go into the corresponding directory, and then transfer all the files up to your server, maintaining the directory structure, and you'll be all set!

That's it! If you run into any problems, feel free to contact me for assistance.

#### Why a REST API for the Cloudy Logic App?

The original Cloudy Logic Studios app was written in Objective C for the iOS platform. For some time, I've been wanting to do an Android version of the app, as well as convert it to Swift for iOS. One of the biggest disadvantages to the original version is that it relied on hard-coded data for the embedded video content, as well as the contact information, etc. So anytime I want/need to change it, I have to rebuild the app and redeploy. This is not good.

So, I decided to use a more flexible method for handling this in the newer versions of the app, and this led me to separating the dynamic content into an API that I could easily access from any platform, in a consistent manner.

And thus was born the CLS REST API.

The server side of the API is contained in this repository, and the remainder of this document will describe it, document it, and hopefully explain everything you want or need to know about it.

#### The Implementation

The CLS REST API server side is written entire in PHP, and uses JSON encoding to expose the data associated with each API call. The APIs available are:

1. versions/ - Returns the versions of a specific (or all) API. 
2. about-us/ - Returns a text description of what Cloudy Logic Studios does.
3. contact-info/ - Returns contact information for Cloudy Logic.
4. reels/ - Returns information about demo reels including a streaming URL.
5. our-work/ - Returns information about select video projects that showcase the company.

In the following section, I'll go over each of the APIs, what they return, and how to use them.

#### http://api.cloudylogic.com/versions[/apiname]/

The /versions API returns an array of objects that describe the implemention and data version for each of the CLS REST APIs. 

##### Examples
[http://api.cloudylogic.com/versions](http://api.cloudylogic.com/versions/) - Returns version data for all APIs
[http://api.cloudylogic.com/versions/reels](http://api.cloudylogic.com/versions/reels/) - Returns version data for the /reels API only

The intent behind this API is to indicate to a client that has cached prior return data whether or not there is any need to request an update, or if it's okay to simply use the locally cached data.

e.g. If my app wants to display the latest demo reel for Cloudy Logic, and I've previously downloaded the demo reel data via the ***/reels*** API, as long as the current data version for **/reels** is the same as what is was when I originally downloaded it, there is no need for me to re-request the demo reel information. Instead, I can simply play the demo reel using the URL I already have cached locally.

#### http://api.cloudylogic.com/about-us/

The /about-us API returns a text description for Cloudy Logic Studios. 

##### Examples
[http://api.cloudylogic.com/about-us/](http://api.cloudylogic.com/about-us/) - Returns information about Cloudy Logic

The intent behind this API is to .

#### http://api.cloudylogic.com/contact-info/

The /contact-info API returns an array of contact information for Cloudy Logic Studios. 

##### Examples
[http://api.cloudylogic.com/contact-info/](http://api.cloudylogic.com/contact-info/) - Returns contact information for Cloudy Logic

##### Sample Return Data
phone
email
social-media \[
	facebook
	twitter
	vimeo
	instagram? - how to add others w/o breaking the api?
\]
mailing address

This API returns the contact information for the business. This includes the typical data, such as mailing address, phone and email, as well as the various social media contacts.

#### http://api.cloudylogic.com/reels[/ID#]/

The /reels API returns information about one or all demo reels for Cloudy Logic Studios. If the optional [ID#] is supplied, then the information for that specific demo reel is returned instead. If the ID number provided is invalid, then information about all demo reels is returned.

> **NOTE** An ID of 0 always refers to the "latest" or newest demo reel. 1 refers to the second latest demo reel, and so on.

##### Examples
[http://api.cloudylogic.com/reels/](http://api.cloudylogic.com/reels/) - Returns information for all Cloudy Logic demo reels.
[http://api.cloudylogic.com/reels/0/](http://api.cloudylogic.com/reels/0/) - Returns information for the latest Cloudy Logic demo reel.
[http://api.cloudylogic.com/reels/1/](http://api.cloudylogic.com/reels/0/) - Returns information for the second latest Cloudy Logic demo reel.

The intent behind this API is to .

#### http://api.cloudylogic.com/our-work[/ID#]/

The /our-work API returns an array of objects that describe videos which showcase some of Cloudy Logic Studios' past projects. It can also return more detailed information on a specific video, if it's ID is passed in. 

##### Examples
[http://api.cloudylogic.com/our-work/](http://api.cloudylogic.com/our-work/) - Returns information about showcased Cloudy Logic past projects.

The intent behind this API is to .

#### Additional Information

Talk about looking at the source code for additional information.
Talk about reviewing the Javascript for the [api.cloudylogic.com] root page
Talk about reviewing the test code written in Java
Talk about reviewing client code for Python, Java, Kotlin, Javascript and Swift

You may want to check out the Python test code for the CLS REST API, that repository, called [testclsrest](https://github.com/kenlowrie/testclsrest) is also available on [GitHub](https://github.com/).


#### Summary

This concludes the documentation on the CLS REST API server side code.