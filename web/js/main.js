const src = document.getElementById('view').getContext('2d');
src.fillStyle = "#FF0000";
let points = [];

let xhr = new XMLHttpRequest();

function getSortedData() {
    xhr.open('POST', '/sort');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            data = JSON.parse(xhr.responseText);
            if (data.continue === false){
                clearInterval(timer);
            }
            points = data.data;
            draw();
        }
        else {
            alert('Request failed.  Returned status of ' + xhr.status);
            clearInterval(timer);
        }
    };
    xhr.send(encodeURI('data=' + JSON.stringify(points)));
}

function draw() {
    //points = JSON.parse(points);
    src.clearRect(0, 0, src.canvas.width, src.canvas.height);
    for (let i = 0, len = points.length; i < len; i++) {
        src.fillRect(points[i].x, points[i].y, 5, 5);
    }
}

timer = setInterval(getSortedData, 50);
