var ctx;
var podium;

function mostrarPodium(){
	podium = document.getElementById('podium');
	if (podium.getContext) {
    const ctx = canvas.getContext('2d');

    const rectangle = new Path2D();
    rectangle.rect(10, 10, 50, 50);
    rectangle.style = background("black");

    const circle = new Path2D();
    circle.arc(100, 35, 25, 0, 2 * Math.PI);

    ctx.stroke(rectangle);
    ctx.fill(circle);
  }
}