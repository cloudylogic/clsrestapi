<?php
// This file is covered by the LICENSE file in the root of this project.

include_once ("../includes/cvideo.php");

/*
**	This function declares a video list array of showcase videos. 
**	Basically, it's a substitution to avoid using a database. Because
**	in my instance, this data hardly ever changes, it's fine to 
**	hardcode the data this way.
*/

function getShowcaseVideos()
{
	$showcaseVideos = new cShowcaseVideos();

	$showcaseVideos->addVideo( "The War Against Cardboard", 
	                           "48014822", 
	                           "87c60fe5fa928f6bc07a869f6881b91313c0849a",
	                           "d878380d21f00402f74cdc9d0672fb6662f1b146&amp;profile_id=113",
	                           "3ec4dfe6ae15be7880faeb622b3b4166dd08c01c&amp;profile_id=112",
	                           "fe6efde006a57fd723bac953da5aac0894aa0f7c&amp;profile_id=116",
	                           "Business Profile Video", 
	                           "img-bizprofile.png", 
	                           "frame-bizprofile.png", 
	                           "Gregg Stepp", 
	                           "", 
	                           "Ken Lowrie",
	                           "Gregg Stepp &amp; Ken Lowrie",
	                           "Put the spotlight on your business with a high quality profile video, " .
	                           "like this one we produced for BungoBox (www.bungobox.com), an innovative " .
	                           "company that rents reusable moving boxes instead of putting more cardboard " .
	                           "into the world. We help you identify your strengths and then highlight " .
	                           "them in a documentary-style movie. Contact us today for a custom quote " .
	                           "and we’ll help you tell YOUR story."
	                           );

	$showcaseVideos->addVideo( "SNAFU - Dixie Sound Check", 
	                           "45207956", 
	                           "47057e66ce60ea99288fba43ed8b06b103233008",
	                           "8765e5b40ea007976d3c9954954e8cd3fb7838f5&amp;profile_id=113",
	                           "466d3a97901863d5219d77deddacb0799214e3b1&amp;profile_id=112",
	                           "4aa446b5f527bf1baaeccb9a10b2091ff716ffeb&amp;profile_id=116",
	                           "Performance Music Video", 
	                           "img-musicvideo.png", 
	                           "frame-musicvideo.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Ken Lowrie &amp; Gregg Stepp",
	                           "Ken Lowrie",
	                           "We love a good music video, and nothing captures the essence of a live " .
	                           "band better than a performance video! And, for artists on a budget, they’re " .
	                           "pretty economical compared to a standard video shoot. Plus, you’ll get the " .
	                           "extra benefit of better locations at less expense, since many venues like " .
	                           "the added exposure. Check out this video we shot for Orlando’s SNAFU " .
	                           "and their song “Dixie Sound Check”. We loved their energy and had a great " .
	                           "time shooting and producing this performance. Get in touch today for a " .
	                           "custom quote on your next video!"
	                           );
	$showcaseVideos->addVideo( "SI.COM - H.S. Player of the Week", 
	                           "16537570", 
	                           "ab0669cc1b4ddebea4735863312466e13a4f3786",
	                           "f39eb60513a5456e1962a8c31e4985c499fd290b&amp;profile_id=113",
	                           "537ba3385e2aa2113de80fbe89d3daf51e19d69b&amp;profile_id=112",
	                           "10230af05e26e79192c6ca1043532a9e83646b92&amp;profile_id=116",
	                           "Sports Documentary Video", 
	                           "img-sportsdoc.png",
	                           "frame-sportsdoc.png", 
	                           "Cloudy Logic", 
	                           "", 
	                           "Ken Lowrie &amp; Willie Sheely",
	                           "Willie Sheely &amp; Ken Lowrie",
	                           "Sure we do standard “highlight” videos, but we really get excited about " .
	                           "doing Sports Documentary profiles for athletes at any level. Here’s one we " .
	                           "shot for the Sports Illustrated High School Player of the Week series when " .
	                           "they highlighted top prospect quarterback Jeff Driskel from Hagerty High " .
	                           "School in Oviedo, Florida. Whether you’re preserving childhood memories " .
	                           "or promoting a future career, these videos are a great way to document the " .
	                           "journey. Call today and together we can figure out which approach is " .
	                           "right for you."
	                           );
	$showcaseVideos->addVideo( "Have Yourself A Merry Little Christmas", 
	                           "56170832", 
	                           "47e93fa60d6186a1c2e9efa1b862413151eb7542",
	                           "12c53f52256f3d12a26ede39fb686b96448e662c&amp;profile_id=113",
	                           "de28dd33dab74a70b32862c5998906461122c9c1&amp;profile_id=112",
	                           "c4b9189e3a5b942ab4362127a3049770e89509ed&amp;profile_id=116",
	                           "Live Performance Multi-Camera", 
	                           "img-live.png", 
	                           "frame-live.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Ken Lowrie &amp; Brenda Lowrie",
	                           "Ken Lowrie &amp; Brenda Lowrie",
	                           "Multi-Camera music videos capture another element of the performance. These " .
	                           "high-end productions are styled to fit the music and the artist and involve " .
	                           "plenty of pre-production to be sure that the final product matches the " .
	                           "original concept. Here’s a simple multi-cam shoot we did for Philip R. " .
	                           "Bonanno’s “Have Yourself A Merry Little Christmas” performance inside the " .
	                           "Cloudy Logic Studios Florida Complex. Give us a call and we can discuss " .
	                           "ideas and options! (Original music by Hugh Martin, lyrics by Ralph Blane)"
	                           );
	$showcaseVideos->addVideo( "Sunsight AAT Training", 
	                           "23581310", 
	                           "33fc66dc90359833793f876092ba379e898f5340",
	                           "06c875643c0295dd491545a1d134efeb760d15dc&amp;profile_id=113",
	                           "d4ad59a3c7984a353cb6f3ecc9c3bfa102fdac2a&amp;profile_id=112",
	                           "3fc50a16604e7a627e96740919ddd7bd0380eecd&amp;profile_id=116",
	                           "Instructional Video", 
	                           "img-aatios.png", 
	                           "frame-aatios.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Ken Lowrie &amp; Brenda Lowrie",
	                           "Ken Lowrie &amp; Brenda Lowrie",
	                           "Training Videos? Gotcha covered! Check out these web-based training videos " .
	                           "that we produced for Sunsight Instruments (www.sunsight.com), a high-tech " .
	                           "company that designs and builds antenna positioning systems for mobile " .
	                           "communications companies. This was a full-service production, with script " .
	                           "development, product photography, video, voiceover, interactive software " .
	                           "capture, and much more done completely in-house at Cloudy Logic Studios. " .
	                           "Of course, we’re happy to handle as much or as little as your production " .
	                           "needs. Give us a call and we can develop a plan to get your training " .
	                           "program up and running, or update what you already have."
	                           );
	$showcaseVideos->addVideo( "Symantec Mini Cooper Spot", 
	                           "23581310", 
	                           "33fc66dc90359833793f876092ba379e898f5340",
	                           "06c875643c0295dd491545a1d134efeb760d15dc&amp;profile_id=113",
	                           "d4ad59a3c7984a353cb6f3ecc9c3bfa102fdac2a&amp;profile_id=112",
	                           "3fc50a16604e7a627e96740919ddd7bd0380eecd&amp;profile_id=116",
	                           "Commercials and Promos", 
	                           "img-commercial.png", 
	                           "frame-commercial.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Willie Sheely",
	                           "Willie Sheely",
	                           "Commercials and Promotional Videos are a great way to get exposure or " .
	                           "highlight a promotion. This promotional video for Symantec " .
	                           "(www.symantec.com) was developed to highlight the benefits of their " .
	                           "NetBackup and BackupExec software versus the competition. Get the " .
	                           "advantage on your competition and engage your customers with video! " .
	                           "Call us today and we can design a plan to work with your budget, no matter " .
	                           "how big or how small."
	                           );
	$showcaseVideos->addVideo( "Dane Colbert Music Demo", 
	                           "92682938", 
	                           "0933127973c447125ddf4bfa65e384b3e4d7036c",
	                           "511a83480c89253a460b5a5ab7724e6d820c1273&amp;profile_id=113",
	                           "746d26976c7a22c694a1b1c55f93178bb4f7c685&amp;profile_id=112",
	                           "ac9f279409a99132629f207553214493ddc9bb27&amp;profile_id=116",
	                           "Artist Promo Video", 
	                           "img-promo.png", 
	                           "frame-promo.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Brenda Lowrie &amp; Ken Lowrie",
	                           "Brenda Lowrie",
	                           "Update your demo and book more clients! Show them what they’ll be missing " .
	                           "if they don’t book you for the gig. Here’s an example of a basic Talent " .
	                           "Demo Reel we produced for Dane Colbert to send to potential clients. Dane’s " .
	                           "huge catalog of cover songs and original tracks is perfect for a wide " .
	                           "variety of events and showing his talents on video has helped increase his " .
	                           "bookings. Get in touch today and we’ll help you get the exposure you " .
	                           "deserve, while respecting your budget."
	                           );
	$showcaseVideos->addVideo( "Phil Bonanno - Living", 
	                           "67075244", 
	                           "90e9277e734b8c527d3d27fc5119ef586e36e280",
	                           "ac252f49472c061f25a8284e9798a7b337b49629&amp;profile_id=174",
	                           "a3f186516142630d6587c310b16bb634ab3fb5e8&amp;profile_id=165",
	                           "a3f186516142630d6587c310b16bb634ab3fb5e8&amp;profile_id=164",
	                           "Single Camera Music Video", 
	                           "img-singlecam.png", 
	                           "frame-singlecam.png", 
	                           "Ken Lowrie", 
	                           "", 
	                           "Ken Lowrie",
	                           "Ken Lowrie",
	                           "Single-camera music videos are less expensive overall than the multi-camera " .
	                           "versions, yet they are still an extremely effective way to highlight your " .
	                           "talent. This is the official music video for &quot;Living&quot;, the first " .
	                           "track from Phil Bonanno&apos;s &quot;Short Songs From a Little Room EP&quot;. " .
	                           "Phil wrote the songs, played all the instruments, and then recorded them all " .
	                           "in the spare &quot;little room&quot; inside his home in downtown Orlando, " .
	                           "Florida. The shoot took place inside that same room over the course of only a " .
	                           "few hours and it has given his fans an intimate look inside his process and " .
	                           "his life."
	                           );
	return $showcaseVideos;
}

?>
