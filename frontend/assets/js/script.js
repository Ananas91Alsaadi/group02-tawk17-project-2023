function showHide(){
    var inputElement=document.getElementById("password");
    var inputType = inputElement.getAttribute('type');
    var newValue = inputType=='text'?'password':'text';
    inputElement.setAttribute('type', newValue);
}

var activeMovie=[];

async function sendAPI(x,homePath){

 
 let response = await fetch('/'+ homePath +'/api/comments/autocomplete/' + x, { 
   method: "GET",
 });
 
 let data = await response.json();
 console.log(data);
return data;

}

async function searchMovies(x,homePath) {

 let data = await sendAPI(x,homePath);
if (data){


   const autocompleteList = document.getElementById("sug");
   autocompleteList.innerHTML = ''; // Clear previous results

   data.results.slice(0, 5).forEach(result => {
     const listItem = document.createElement('li');
     let releaseDate=result.release_date?' - '+result.release_date.substring(0, 4):'';
     let MovieTitle= result.title?result.title+' '+releaseDate:result.name+' '+releaseDate;

     listItem.innerHTML = '<a href="movie/'+result.id+'">'+MovieTitle+'</a>'
      console.log(result.id);
  
     autocompleteList.appendChild(listItem);
   });

   if (autocompleteList.innerHTML == ''){
    autocompleteList.style.display="none"
   }else{autocompleteList.style.display="block"}
   
  }

}

window.addEventListener('DOMContentLoaded', () => {
  
document.querySelectorAll('.user-name').forEach((element) => {
  const randomColor = `rgb(${getRandomValue(255)}, ${getRandomValue(255)}, ${getRandomValue(255)})`;
  element.style.backgroundColor = randomColor;

});

});

function getRandomValue(max) {
  return Math.floor(Math.random() * (max + 1));
}

function changeColor(x){
// Get all the rating star labels and input radio buttons
const starLabels = document.querySelectorAll('.rating-labels');
console.log(starLabels);
// Function to change the color of the star labels based on the selected radio button value
  const selectedValue = x;

  starLabels.forEach((label, index) => {
    if (index < selectedValue) {
      label.style.color = '#e48099'; // Change the color to red for labels up to the selected value
    } else {
      label.style.color = '#aaa'; // Change the color back to the default color for labels after the selected value
    }
  });

}


