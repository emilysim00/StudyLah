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
            <button class="btn" onclick="filterSelection('ac')"> Air-Conditioned</button>
            <button class="btn" onclick="filterSelection('ports')"> Have Charging Ports</button>
            <button class="btn" onclick="filterSelection('food')"> Food</button>
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
        <div class="pictures filterDiv ac"><img src="reco/2ndlevelYIHstudyroom.JPG" alt="2nd Level YIH Study Room" ></div>
        <div class="info filterDiv ac">
            <h2>2nd Level YIH Study Room</h2></br>
                <p> 
                    Location: Yusof Ishak House, Level 2</br>
                    Operating Hours: - </br></br>
                    Air-Conditioned</br>
                    Open Space
                </p>  
                
        </div>
        <div class="pictures filterDiv ac ports"><img src="reco/2ndlvltownplaza.JPG" alt="2nd Level Town Plaza"></div>
        <div class="info filterDiv ac ports">
            <h2>2nd Level Town Plaza</h2></br>
                <p>
                    Location: Above Fine Food, Town Plaza Level 2</br>
                    Operating Hours: - </br></br>
                    Air-Conditioned</br>
                    Open Space, Seats with Power Source
                </p>
        </div>
    
    <div class="pictures filterDiv ac ports"><img src="reco/CentralLibrary.JPG" alt="Central Library"></div>
        <div class="info filterDiv ac ports">
            <h2>Central Library</h2></br>
                <p>
                    Location: Central Library, near FASS</br>
                    Operating Hours: </br>
                    Mon to Fri: 09:00 – 21:00</br>
                    Vacation Term Operating Hours: </br>
                    Mon-Fri: 09:00 - 18:00 </br></br>
                    Air-Conditioned</br>
                    Has 6 Levels, Level 3 is for Group Meetings & Discussions</br>
                    Offers Printing Services</br></br>
                    *Accessible only to staff, faculty and students of Yale-NUS College & NUS. Members of the NUS Community should enter the Library using Level 1 entrance with Student Card.</br>
                </p>
        </div>
    
    <div class="pictures filterDiv ac ports"><img src="reco/ComputerCommon.JPG" alt="Computer Common"></div>
        <div class="info filterDiv ac ports">
            <h2>PC Common</h2></br>
                <p>
                    Location: UTown, Education Resource Centre Level 1(ERC)</br>
                    Operating Hours: </br>
                    Mon to Sun: 08:00 – 22:00</br></br>
                    
                    Air-Conditioned</br>
                    Offers Printing Services</br>
                    Individual need to scan their student card to access the room.
                </p>
        </div>
    
    <div class="pictures filterDiv ac ports 24"><img src="reco/erc.JPG" alt="Educational Resource Center"></div>
        <div class="info filterDiv ac ports 24">
            <h2>Educational Resource Center</h2></br>
                <p>
                    Location: UTown, Education Resource Centre Level 4(ERC)</br>
                    Operating Hours: </br>
                    24/7</br></br>

                    Air-Conditioned</br>
                    Individual Seating with Power Source.</br>
                    Individual need to scan their student card to access the room.
                </p>
        </div>
    
    <div class="pictures filterDiv ac ports 24"><img src="reco/erclvl2.JPG" alt="Educational Resource Center Level 2"></div>
        <div class="info filterDiv ac ports 24">
            <h2>Educational Resource Center, The Study Level 2</h2></br>
                <p>
                    Location: UTown, Education Resource Centre Level 1(ERC)</br>
                    Operating Hours: </br>
                    24/7</br></br>
                    Air-Conditioned</br>
                    Individual Seating with Power Source. </br>
                    Individual need to scan their student card to access the room.
                </p>
        </div>
    
    <div class="pictures filterDiv ac ports 24"><img src="reco/MACcommons.JPG" alt="Mac Common"></div>
        <div class="info filterDiv ac ports 24">
            <h2>Mac Common</h2></br>
                <p>
                    Location: UTown, Education Resource Centre Level 1(ERC)</br>
                    Operating Hours: </br>
                    24/7</br></br>
                    Air-Conditioned</br>
                    Collaborative learning</br>
                    Individual need to scan their student card to access the room.
                </p>
        </div>
    
    <div class="pictures filterDiv ports 24"><img src="reco/outsideERC.JPG" alt="Outside of Educational Resource Center"></div>
        <div class="info filterDiv ports 24">
            <h2>Outside of Educational Resource Center</h2></br>
                <p>
                    Location: Education Resource Centre Level 2 (ERC)</br>
                    Operating Hours: </br>
                    24/7</br></br>
                    Non-AirConditioned</br>
                    Seats with Power Source.
                </p>
        </div>
   
    <div class="pictures filterDiv ports 24"><img src="reco/outsideUtown.JPG" alt="Outside of UTown Starbucks"></div>
        <div class="info filterDiv ports 24">
            <h2>Outside of UTown Starbucks</h2></br>
                <p>
                    Location: Education Resource Centre (ERC) Level 1</br>
                    Operating Hours: </br>
                    24/7</br></br>
                    Non-AirConditioned</br>
                    Seats with Power Source.
                </p>
        </div>
   
    <div class="pictures filterDiv ac food"><img src="reco/starbucksutown'.JPG" alt="UTown Starbucks"></div>
        <div class="info filterDiv ac food">
            <h2>UTown Starbucks</h2></br>
                <p>
                    Location: Education Resource Centre (ERC)</br>
                    Operaring Hours:</br>
                    Mon-Sun, 8.00am-10.00pm</br>
                    Contact No: 6659 6081</br></br>
                    Air-Conditioned
                </p>
        </div>
  
    <div class="pictures filterDiv ac ports"><img src="reco/yale-nus.JPG" alt="Yale-NUS Library"></div>
        <div class="info filterDiv ac ports">
            <h2>Yale-NUS Library</h2></br>
                <p>
                    Location: University Town </br>
                    Mon-Thu: 8.30am-6pm</br>
                    Fri: 8.30am-5.30pm</br>
                    Sat & Sun and Public Holidays: CLOSED</br>
                    Contact: 6601 3551</br></br>
                    Air-Conditioned</br></br>
                    *Accessible only to staff, faculty and students of Yale-NUS College & NUS.
                    Members of the NUS Community should enter the Library using our Level 1 entrance (below Café Agora), 
                    and must register themselves at the service desk for contact tracing purposes.</br>
                </p>
        </div>

</div>
</body>