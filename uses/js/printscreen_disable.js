// JavaScript Document

function copyToClipboard() {
  // Create a "hidden" input
  var aux = document.createElement("input");
  // Assign it the value of the specified element
  aux.setAttribute("value", "VocÃª nÃ£o pode mais dar printscreen. Isto faz parte da nova medida de seguranÃ§a do sistema.");
  // Append it to the body
  document.body.appendChild(aux);
  // Highlight its content
  aux.select();
  // Copy the highlighted text
  document.execCommand("copy");
  // Remove it from the body
  document.body.removeChild(aux);
  alert("You Cannot Print This Page. Page Contains Copyright Material");
}

$(window).keyup(function(e){
  if(e.keyCode == 44){
    copyToClipboard();
  }
}); 

$(window).focus(function() {
  $("body").show();
}).blur(function() {
  $("body").hide();
});;