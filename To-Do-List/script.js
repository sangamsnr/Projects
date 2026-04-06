
const inputBox = document. getElementById("input-box");
const listContainer = document. getElementById("list-container");
function addTask(){
    if (inputBox.value === ''){
        alert("You must write something!");

    }
    else{
        let li = document.createElement("li");
        li.innerHTML = inputBox.value;
        listContainer.appendChild(lib);
        let span = document.createElement("span");
        span.innnerHTMl = "\u00d7";
        li.appendChild(span);
    }
    inputBox.value = "";
    saveData();
}

listContainer.addEventListener("click",function(e){
    if(e.target.tagName === "LI"){
        e.target.classList.toggle("checked");
    }
    else if (e.target.tagName === "SPAN"){
        e.Target.parentElement.remove();
        saveData();
    
    }
}, false);

function saveData (){
    localStorage.setItem("data",listContainer.innerHTML);
}

function showTask(){
    listContainer.innnerHTMl = localStorage.getItem("data");

}
showTask();


        

    
    
    

