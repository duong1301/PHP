
<div class="darksoul-dropdown-js ml-50 mt-50">
    <button onclick="dropdown()" class="darksoul-btn-medium white" type="button">v</button>
    <ul id="jsDropdown" class="darksoul-dropdown-content-js">
      <li class="darksoul-dropdown-item-js"><a class="none black" href="./index.php?page=account">Action</a></li>
      <li class="darksoul-dropdown-item-js"><a class="none black" href="./logout.php">Đăng xuất</a></li>
    </ul>
</div>   

<style>
    
/* Dropdowns - Js - Start */
.darksoul-dropdown-js button{
    border: unset;
    width: 16px;
    height: 16px;
    cursor: pointer;
    background-color: unset;
}
.darksoul-dropdown-js
{
    position: relative;    
}
.darksoul-dropdown-content-js
{
    position: absolute;
    display: none;
    right: 0;
    top: 42px;
    list-style: none;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.darksoul-dropdown-item-js
{
    display: block;
    height: 30px;
}
.darksoul-dropdown-item-js:hover
{
    background-color: rgb(255, 255, 255);
    font-weight: bold;
}
.show-dropdown 
{
    display: flex;
    flex-direction: column;
    padding: 15px;
    background-color: rgb(255, 255, 255);    
    list-style: none;
    box-shadow: 0px 0px 10px rgb(168, 167, 167);
    border-radius: 5px;
    margin-top: 0px;
}

/* Dropdowns - Js - End */
</style>

<script>
    // Js - Dropdown - Start

const jsDropdown = document.getElementById("jsDropdown");
function dropdown() {
jsDropdown.classList.toggle("show-dropdown");
}
 document.documentElement.addEventListener
("click", function (event) 
{
     if (!event.target.matches('.darksoul-btn-medium')) 
     {
         if (jsDropdown.classList.contains("show-dropdown")) 
         {
             jsDropdown.classList.toggle("show-dropdown");          }
     } }
);

// Js - Dropdown - End
</script>