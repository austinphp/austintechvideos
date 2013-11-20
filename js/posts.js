var posts = [
    {
        title: "Intro to Apache Cassandra",
        stamp: "2013-05-23",
        videoid: "GUW5ewtaVBQ",
        description: "Apache Cassandra chair Jonathan Ellis gives an introduction to the Cassandra project.",
        category: "Cassandra Austin"
    },
    {
        title: "How to (Not) Version Your API",
        stamp: "2013-05-22",
        videoid: "XRCx1LuIGo4",
        description: "BazaarVoice Developer Evangelist Michael Pratt talks about how to version...and how to not version...and how not to version...your APIs at the second meetup of AustinAPI.",
        category: "Austin API"
    },
    {
        title: "Automation and elasticity: The economics of devops",
        stamp: "2013-05-14",
        videoid: "T71U_Tp0jK4",
        description: "by Boyd Hemphill, FeedMagnet system architect, and Jason Ford, FeedMagnet founder",
        category: "Refresh Austin"
    },
    {
        title: "Building a video game company through social capital",
        stamp: "2013-05-14",
        videoid: "zb5Md-Ef7co",
        description: "by Jo Lammert, White Whale Games studio director.  White Whale Games started in summer of 2011 when Jo Lammert and two friends, spurred by a conversation about pulp fantasy and video games, decided to make a game company. Each member of the team had little to no experience in the industry, and the new company had next to no money; So how exactly did White Whale go from chatting about wizards and swords to releasing the critically-acclaimed God of Blades? Learn about the team's struggles and successes in indie game development--and how they were able to build a game studio with just a few ideas and an eagerness to learn.",
        category: "Refresh Austin"
    },
    {
        title: "SimpleXML and DOM",
        stamp: "2013-05-11",
        videoid: "-7vkE9BHVcg",
        description: "Logan Lindquist talks about what you can do with SimpleXML and DOM. Web scraping, XML generation, configuration management, APIs .. etc.",
        category: "Austin PHP"
    },
    {
        title: "Zend Franework 2",
        stamp: "2013-05-10",
        videoid: "qALNlotBCfE",
        description: "Zend Framework's Ralph Schindler stops by to talk about ZF2",
        category: "Austin PHP"
    },
    {
        title: "Capybara",
        stamp: "2013-05-06",
        videoid: "YGOcpcQMJfM",
        description: "Daniel Hedrick gives an introduction to testing web applications in Rails with Capybara.",
        category: "Austin on Rails"
    },
    {
        title: "Build an App with Sails.JS - Part 2",
        stamp: "2013-05-11",
        videoid: "wXZz6SAiwzY",
        description: "Continuing building a Sials.JS app",
        category: "Sails.JS"
    },
    {
        title: "Build an App with Sails.JS - Part 1",
        stamp: "2013-05-06",
        videoid: "PUQFnXbnJgU",
        description: "Mike McNeil, creator of Sails.JS, gives an introduction to the Sails.JS framework.",
        category: "Sails.JS"
    },
    {
        title: "AngularJS - First Meetup",
        stamp: "2013-05-06",
        videoid: "YuhGlWUtCGw",
        description: "Hacking together a first project using AngularJS at the Wells Branch Library",
        category: "AngularJS"
    },
    {
        title: "Get More From Your Content with Reader Aware Design",
        stamp: "2013-05-06",
        videoid: "4mAdp2EXgak",
        description: "Presentation by Ben Brown (CEO XOXCO, @benbrown) What happens to your content when it falls off the front page? How can we as web publishers do a better job of merchandising our content? Brown will explore methods for building more value for readers and publishers by using reader aware design techniques, and by re-imagining content archives as a back catalog.",
        category: "Refresh Austin"
    },
    {
        title: "Adaptive Images for Responsive Web Design",
        stamp: "2013-05-06",
        videoid: "K63UL8n-03Q",
        description: "Presented by Christopher Schmitt (@teleject, founder of Heatvision) at Refresh Austin. The open web doesn't stop at our desktop. Smart phones and tablets not only contain more computing power and better browsers than the computers that started the Internet economy, they have better displays. In this session presented by Christopher Schmitt, we work through tips and tricks to develop future friendly images in our sites and apps",
        category: "Refresh Austin"
    },
    {
        title: "Slow Web Pages Suck",
        stamp: "2013-04-25",
        videoid: "PpXIOD2TFgs",
        description: "Presented by Chris Holmok & Mike Cravey from RetailMeNot. RetailMeNot lazily fell into the popular trend of feature bloat over site performance. This is the implementation level view of how they got faster, how they proved it and where they are going from here. Mike Cravey is señor/managing UI Engineer at RetailMeNot where he is saving you money and bytes. He came to development the long way as a sys admin and then a designer. Mike fights for the rights of UI Engineering since many think they're just \"making it pretty\". Chris Holmok started writing code when the DeLorean went into production. Originally from Cleveland, OH, he has worked for MySpace, Microsoft, Knotice, and OEConnection. Chris enjoys making music, photography, drinking obscure European Liquors and has a cat named Betty.",
        category: "Austin Web Performance"
    },
    {
        title: "REST Basics",
        stamp: "2013-04-24",
        videoid: "pvZ98vG_RAQ",
        description: "Keith Casey of Twilio gives an introduction to RESTful APIs at the inaugural meeting of AustinAPI.",
        category: "Austin API"
    },
    {
        title: "Drupal and Node.JS",
        stamp: "2013-04-18",
        videoid: "4t680hXOafQ",
        description: "Presented by Mike Minecki from Four Kitchens. Drupal and Node.js go together like bread and butter, or milk and cereal or a burger and fries. We'll talk about 3 different projects that mixed and matched Drupal and Node.js in different configurations and architectures to meet a variety of business goals. A website that featured a live-feed of new Drupal content being created during a live event, a web app that allows users to create and share magnetic poems on everything from a smartphone to the desktop, and a website that needed to pull in a staggering number of real time feeds.    Mike Minecki has been building websites since 1999. At Four Kitchens he helped build and architect a number of different projects that utilized both Node.js and Drupal. He has taught Node.js in Austin and San Fransisco, and has been speaking at events around the country about how to integrate Node.js and Drupal.",
        category: "Austin Node"
    }
];

for (var p in posts)
{
    if (!posts.hasOwnProperty(p)) continue;
    posts[p].stub = posts[p].title.replace(/\s/g, "-").toLowerCase().substr(0,60);
}