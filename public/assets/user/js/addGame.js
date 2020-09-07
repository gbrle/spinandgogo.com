let blockAddGame = document.getElementById('blockAddGame');
let blockAddGameRoom = document.getElementById('blockAddGameRoom');
let blockRooms = document.getElementById('blockRooms');


blockAddGame.addEventListener('click', function (){
    blockAddGame.classList.remove('intro-y')
    blockAddGame.classList.add('animate__bounceOutLeft')
    setTimeout(function(){
        blockAddGame.style.display = 'none'
        blockAddGameRoom.style.display = "block"
        blockRooms.style.display = "block"

    }, 500);
})

function addRoom(roomId){
    blockAddGameRoom.classList.remove('intro-y')
    blockRooms.classList.remove('intro-y')
    blockAddGameRoom.classList.add('animate__bounceOutLeft')
    blockRooms.classList.add('animate__bounceOutLeft')
    setTimeout(function(){
        blockAddGameRoom.style.display = 'none'
        blockRooms.style.display = 'none'

    }, 500);


}