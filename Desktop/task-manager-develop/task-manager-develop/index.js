const fs = require('fs');
const path = './tasks.json';

function completarTarea(index) {
    const tareas = leerTareas();
    if (tareas[index]) {
      tareas[index].completada = true;
      guardarTareas(tareas);
      console.log('Tarea completada:', tareas[index].titulo);
    } else {
      console.log('Tarea no encontrada.');
    }
function crearTarea(titulo) {
  const tareas = leerTareas();
  tareas.push({ titulo, completada: false });
  guardarTareas(tareas);
  console.log('Tarea creada:', titulo);
}
  }
  switch (comando) { 
    case 'crear':
    crearTarea(argumento);
    break;
    
  case 'completar':
  completarTarea(parseInt(argumento) - 1);
  break;
}