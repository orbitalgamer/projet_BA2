// Sélectionnez l'élément que vous voulez observer
const elementToObserve = document.querySelector('#myChart');

// Créez l'instance de l'observateur d'intersection
const observer = new IntersectionObserver(entries => {
  // Pour chaque entrée dans la liste des entrées
  entries.forEach(entry => {
    // Si l'élément cible est visible
    if (entry.isIntersecting) {
      // Activer le script ici
      
var myChart = new Chart(document.getElementById('myChart'), {
  type: 'pie',
  data: {
      title : "Boujour",
    labels: ['Trouble détecté', 'Trouble non détecté'],
    datasets: [{
      backgroundColor: ['#ff6384', '#36a2eb'],
      data: [149270, 49757]
    }]
  },
  options: {
    plugins: {
      tooltip: false,
      legend: {
          labels: {
              // This more specific font property overrides the global property
              font: {
                  size: 20
              }
          }
      }
  },
  borderColor : '#eeeeee77',
  rotation: 90, 
    responsive: false,
    animation: {
      animateScale: true
    },
    animation: {
      duration: 2000 // Définit la durée de l'animation à 5 secondes
    },
    hover: {
      mode: null
    }
  }
});

      console.log('L\'élément est visible !');
      // Arrêtez d'observer l'élément une fois qu'il est visible
      observer.unobserve(entry.target);
    }
  });
});

// Démarrez l'observation de l'élément cible
observer.observe(elementToObserve);


