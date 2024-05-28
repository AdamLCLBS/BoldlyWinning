  document.addEventListener("DOMContentLoaded", function() {
    // Récupère l'élément du champ de saisie de mot de passe
    let x = document.getElementById("mdp");
    // Masque le champ de saisie de mot de passe
    x.type = "password";
});
    function myFunction() {
        let x = document.getElementById("mdp");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "text";
        }
    }
 


    function toggleDivs() {
        var div1 = document.getElementById("div1");
        var div2 = document.getElementById("div2");
    
        // Utilisation de la méthode toggle() pour basculer la visibilité
        div1.style.display = (div1.style.display === "none") ? "block" : "none";
        div2.style.display = (div2.style.display === "none") ? "block" : "none";
    } 