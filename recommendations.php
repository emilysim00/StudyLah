<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="css\recommend.css">
    <link rel="stylesheet" href="css\navbar.css">
    <title>StudyLah</title>
</head>
<body>
    <?php include('header.php');?>
    <div class="all">
    <div class="but">
        <a href="studylocation.php"><button>Study Location</button></a>
        <a href="recommendations.php"><button>Food</button></a>
    </div>  

    <style>
        .filterDiv { /*hide all items by default*/
        display: none;
        }

        .show {
        display: block;
        }

        .container {
        margin-top: 20px;
        overflow: hidden;
        }

        /* Style the buttons */
        .btn {
        border: none;
        outline: none;
        padding: 12px 16px;
        background-color: #f1f1f1;
        cursor: pointer;
        color:black;
        }

        .btn:hover {
        background-color: #ddd;
        }

        .btn.active {
        background-color: #666;
        color: white;
        }
    </style>

    <div class="selection">
        <div id="myBtnContainer">
            <button id="mybutton" class="btn active" onclick="filterSelection('all')"> Show all</button>
            <button class="btn" onclick="filterSelection('air')"> Air-Conditioned</button>
            <button class="btn" onclick="filterSelection('non-ac')"> Non Air-Conditioned</button>
            <button class="btn" onclick="filterSelection('halal')"> Have Halal Food</button>
            <button class="btn" onclick="filterSelection('utown')"> UTown</button>
            <button class="btn" onclick="filterSelection('drinks')"> Drinks</button>
            <button class="btn" onclick="filterSelection('24')"> Operate 24/7</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            document.getElementById("mybutton").click();
        });

        filterSelection("all")
        function filterSelection(c) {
        var x, i;
        x = document.getElementsByClassName("filterDiv");
        if (c == "all") c = "";
        for (i = 0; i < x.length; i++) {
            w3RemoveClass(x[i], "show");
            if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
        }
        }

        function w3AddClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
        }
        }

        function w3RemoveClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);     
            }
        }
        element.className = arr1.join(" ");
        }

        // Add active class to the current button (highlight it)
        var btnContainer = document.getElementById("myBtnContainer");
        var btns = btnContainer.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function(){
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
        }
    </script>

    <div class="middle container">
        <div class="pictures filterDiv air halal"><img src="reco/BistroBox.JPG" alt="Bistro Box" ></div>
        <div class="info filterDiv air halal">
            <h2>Bistro Box</h2></br>
                <p> Location: Faculty of Engineering / School of Design & Environment</br></br>
                    Operating Hours:</br>
                    Mon-Fri, 7.30am-9.00pm</br>
                    Sat, 7.30-am-3.00pm</br>
                    Sun/PH closed
                </p>  
                
        </div>
        <div class="pictures filterDiv air"><img src="reco/CentralSquare.JPG" alt="Central Square"></div>
        <div class="info filterDiv air">
            <h2>Central Square</h2></br>
                <p>
                    Location: Yusof Ishak House Level 2 </br></br>
                    Operating Hours: </br>
                    Mon-Fri, 8.00am-8.00pm </br>
                    Sat, 8.00am-3.00pm </br>
                    Sun/PH closed 
                </p>
        </div>
        <div class="pictures filterDiv air halal utown"><img src="reco/FineFood.JPG" alt="Fine Food"></div>
        <div class="info filterDiv air halal utown">
            <h2>Fine Food</h2></br>
            <p>
                Location: Town Plaza (Utown)</br></br>
                Operating Hours:</br>
                Mon-Sun, 7.00am-10.00pm
            </p>    
        </div>
        <div class="pictures filterDiv air halal 24 utown"><img src="reco/Flavors.JPG" alt="Flavors"></div>
        <div class="info filterDiv air halal 24 utown">
            <h2>Flavors @ Utown</h2></br>
            <p>
                Location: UTown Stephen Riady Centre</br></br>
                Operating Hours:</br>
                Mon-Sun: 24 hours   
            </p>    
        </div>
        <div class="pictures filterDiv non-ac halal"><img src="reco/foodclique.JPG" alt="Foodclique"></div>
        <div class="info filterDiv non-ac halal">
            <h2>Foodclique</h2></br>
            <p>
                Location: PGPR </br></br>
                Operating Hours: </br>
                Mon-Sun, 7.00am-9.30pm
            </p>    
        </div>
        <div class="pictures filterDiv non-ac halal"><img src="reco/frontier.JPG" alt="Frontier"></div>
        <div class="info filterDiv non-ac halal">
            <h2>Frontier</h2></br>
            <p>
                Location: Faculty of Science </br></br>
                Operating Hours:</br>
                Mon-Fri, 7.30am-4.00pm/8.00pm*</br>
                Sat, 7.30-am-3.00pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air utown"><img src="reco/Hwangs.JPG" alt="Hwang's Korean Restaurant"></div>
        <div class="info filterDiv air utown">
            <h2>Hwang's Korean Restaurant</h2></br>
            <p>
                Location: Town Plaza (Utown) </br></br>
                Operating Hours:</br>
                Mon-Sat, 10.00am-10.00pm</br>
                Contact No: 9833 0603</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air halal drinks"><img src="reco/maxxCoffee.JPG" alt="Maxx Coffee"></div>
        <div class="info filterDiv air halal drinks">
            <h2>Maxx Coffee</h2></br>
            <p>
                Location: Central Library </br></br>
                Term Time Operating Hours: </br>
                Mon-Fri: 9.00am-7.00pm</br>
                Sat: 9.00am to 75.00pm</br>
                Sun/PH: Closed</br></br>
                Vacation Operating Hours:</br>
                Mon-Fri: 9.00am to 5.00pm</br>
                Sat-Sun/PH: Closed
            </p>    
        </div>
        <div class="pictures filterDiv drinks non-ac"><img src="reco/ninefresh.JPG" alt="Ninefresh" ></div>
        <div class="info filterDiv non-ac drinks">
            <h2>Ninefresh</h2></br>
            <p>
                Location: Faculty of Science</br></br>
                Term Time Operating Hours:</br>
                Mon-Sat, 11.00am – 8.00pm</br>
                Sun/PH closed</br></br>
                Vacation Operating Hours:</br>
                Mon-Sat, 11.00am – 3.00pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air halal"><img src="reco/PGPRAircon.JPG" alt="PGPR Aircon Food Court"></div>
        <div class="info filterDiv air halal">
            <h2>PGPR Aircon Food Court</h2></br>
            <p>
                Location: PGPR</br></br>
                Operating Hours:</br>
                Mon-Fri, 7.00am-8.30pm</br>
                Sat, 8.00am-8.30pm</br>
                Sun/PH, 8.00am-8.00pm
            </p>    
        </div>
        <div class="pictures filterDiv air drinks"><img src="reco/reedzCafe.JPG" alt="Reedz Cafe" ></div>
        <div class="info filterDiv air drinks">
            <h2>Reedz Cafe</h2></br>
            <p>
                Location: Shaw Foundation Alumni House</br></br>
                Operating Hours:</br>
                Mon-Fri, 8.30am-5.30pm</br>
                Sat/Sun, 8.00am-3.00pm</br>
                PH closed</br>
                Contact No: 6774 5898
            </p>    
        </div>
        <div class="pictures filterDiv air utown"><img src="reco/sapro.JPG" alt="Sapore Italian Restaurant" ></div>
        <div class="info filterDiv air utown">
            <h2>Sapore Italian Restaurant</h2></br>
            <p>
                Location: Town Plaza (Utown)</br></br>
                Operating Hours:</br>
                Mon-Sun, 11.00am-10.00pm</br>
                Contact No: 6262 0287
            </p>    
        </div>
        <div class="pictures filterDiv air halal drinks"><img src="reco/Starbucks.JPG" alt="Starbucks"></div>
        <div class="info filterDiv air halal drinks">
            <h2>Starbucks</h2></br>
            <p>
                Location: S9</br>
                Operating Hours:</br>
                Mon-Fri: 7.30am to 9.00pm</br>
                Sat – Sun: Closed</br></br>
                Location: Faculty of Engineering / School of Design & Environment</br>
                Operating Hours:</br>
                Mon-Fri: 7.30am to 8.00pm</br>
                Sat-Sun: Closed
            </p>    
        </div>
        <div class="pictures filterDiv non-ac halal"><img src="reco/Subway.JPG" alt="Subway"></div>
        <div class="info filterDiv non-ac halal">
            <h2>Subway</h2></br>
            <p>
                Location: Yusof Ishak House</br></br>
                Halal Certified</br>
                Term Time Operating Hours:</br>
                Mon-Sun, 10.00am-10.00pm</br>
                Vacation Operating Hours:</br>
                Mon-Sun, 10.00am-4.00pm
            </p>    
        </div>
        <div class="pictures filterDiv non-ac halal"><img src="reco/TechnoEdge.JPG" alt="Techno Edge"></div>
        <div class="info filterDiv non-ac halal">
            <h2>Techno Edge</h2></br>
            <p>
                Location: Faculty of Engineering / School of Design & Environment</br></br>
                Operating Hours:</br>
                Mon-Fri, 7.30am-4.00pm/8.00pm*</br>
                Sat, 7.30-am-3.00pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air drinks"><img src="reco/TheCoffeeRoaster.JPG" alt="The Coffee Roaster"></div>
        <div class="info filterDiv air drinks">
            <h2>The Coffee Roaster</h2></br>
            <p>
                Location: Blk AS8</br></br>
                Term Time Operating Hours:</br>
                Mon-Fri, 7.30am-7.00pm</br>
                Sat, 9.00am-5.00pm</br>
                Sun/PH closed</br></br>
                Vacation Operating Hours:</br>
                Mon-Fri, 7.30am-5.30pm</br>
                Sat/Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv non-ac halal"><img src="reco/TheDeck.jpg" alt="The Deck"></div>
        <div class="info filterDiv non-ac halal">
            <h2>The Deck</h2></br>
            <p>
                Location: Faculty of Arts & Social Sciences</br></br>
                Operating Hours: </br>
                Mon-Fri, 7.30am-4.00pm/8.00pm*</br>
                Sat,7.30am-3.00pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air halal utown"><img src="reco/TheRoyalBistrol.jpg" alt="The Royal Bistro"></div>
        <div class="info filterDiv air halal utown">
            <h2>The Royal Bistro</h2></br>
            <p>
                Location: Town Plaza (UTown)</br></br>
                Halal Certified </br>
                Operating Hours: </br>
                Mon-Sat, 11.00am-8.30pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air utown"><img src="reco/TheUdonBar.jpg" alt="Udon Don Bar"></div>
        <div class="info filterDiv air utown">
            <h2>Udon Don Bar</h2></br>
            <p>
                Location: Town Plaza (UTown)</br></br>
                Operating Hours: </br>
                Mon-Sat, 11.00am-10.00pm</br>
                Sun/PH closed
            </p>    
        </div>
        <div class="pictures filterDiv air utwon"><img src="reco/WaaCow.jpg" alt="Waa Cow"></div>
        <div class="info filterDiv air utwon">
            <h2>Waa Cow</h2></br>
            <p>
                Location: Stephen Riady Centre (SRC) (UTown)</br></br>
                Term Time Operating Hours:</br>
                Mon-Thu, 11.30am-7.30pm</br>
                Fri, 11.30am-9.30pm</br>
                Sat, 12.00pm-3.00pm</br>
                Sun/PH closed</br>
                Vacation Operating Hours:</br>
                Mon-Fri, 11.30am-5.30pm</br>
                Sat, 12.00pm-3.00pm</br>
                Sun/PH closed
            </p>    
        </div>
    </div>
</div>
</body>