let blockAddGame = document.getElementById('blockAddGame');
let blockAddGameRoom = document.getElementById('blockAddGameRoom');
let blockRooms = document.getElementById('blockRooms');
let blockAddBuyIn = document.getElementById('blockAddBuyIn');
let blockBuyIn = document.getElementById('blockBuyIn');
let blockAddMultiplicator = document.getElementById('blockAddMultiplicator');
let blockMultiplicator = document.getElementById('blockMultiplicator');
let blockAddRanked = document.getElementById('blockAddRanked');
let blockRanked = document.getElementById('blockRanked');
let blockConfirmAddGame = document.getElementById('blockConfirmAddGame');
let blockConfirmAddGameButton = document.getElementById('blockConfirmAddGameButton');

let dataAddGame = {}

blockAddGame.addEventListener('click', function (){
    blockAddGame.classList.remove('intro-y')
    blockAddGame.classList.add('animate__fadeOutDown')
    setTimeout(function(){
        blockAddGame.style.display = 'none'
        blockAddGameRoom.style.display = "block"
        blockRooms.style.display = "block"

    }, 300);
})

function addRoom(id_room){
    blockAddGameRoom.classList.remove('intro-y')
    blockRooms.classList.remove('intro-y')
    blockAddGameRoom.classList.add('animate__fadeOutDown')
    blockRooms.classList.add('animate__fadeOutDown')
    dataAddGame.id_room = id_room;

    console.log(dataAddGame)

    ajaxPost('/user/user_get_buy_in', id_room, function (response){

        let responseBuyIn = JSON.parse(response)

        setTimeout(function(){
            blockAddGameRoom.style.display = "none"
            blockRooms.style.display = "none"

            let buyButtons = document.getElementById('buyButtons')

            let tabBuyInId = []
            let tabBuyInValue = []
            responseBuyIn.forEach(element => tabBuyInId.push(element.id));
            responseBuyIn.forEach(element => tabBuyInValue.push(element.value));
            blockAddBuyIn.style.display = 'block'
            blockBuyIn.style.display = 'block'

            for (i = 0; i < tabBuyInId.length; i++) {
                let button = document.createElement("button");
                button.classList.add('paste')
                button.id = tabBuyInId[i]
                button.innerText = tabBuyInValue[i]+'€'


                let buyInId = tabBuyInId[i]
                let buyVAlue = tabBuyInValue[i]

                button.onclick = function (){
                    ajaxPost('/user/user_get_multiplicator', buyInId, function (response){

                        let responseMultiplicator = JSON.parse(response)

                        dataAddGame.id_buyIn = buyInId
                        dataAddGame.buy_in_value = buyVAlue

                        console.log(dataAddGame)


                        blockAddBuyIn.classList.remove('intro-y')
                        blockBuyIn.classList.remove('intro-y')
                        blockAddBuyIn.classList.add('animate__fadeOutDown')
                        blockBuyIn.classList.add('animate__fadeOutDown')
                        setTimeout(function(){
                            blockAddBuyIn.style.display = "none"
                            blockBuyIn.style.display = "none"

                            let multiplicatorButtons = document.getElementById('multiplicatorButtons')

                            let tabMultiplicatorId = []
                            let tabMultiplicatorValue = []
                            responseMultiplicator.forEach(element => tabMultiplicatorId.push(element.id));
                            responseMultiplicator.forEach(element => tabMultiplicatorValue.push(element.value));
                            blockAddMultiplicator.style.display = 'block'
                            blockMultiplicator.style.display = 'block'

                            for (i = 0; i < tabMultiplicatorId.length; i++) {
                                let button = document.createElement("button");
                                button.classList.add('paste')
                                button.id = tabMultiplicatorId[i]
                                button.innerText = 'x' + tabMultiplicatorValue[i] + ' (' + (tabMultiplicatorValue[i] * dataAddGame.buy_in_value + '€') + ')'
                                button.onclick = function (){
                                    ajaxPost('/user/user_get_ranked', multiplicatorId, function (response){
                                        let responseRanked = JSON.parse(response)

                                        dataAddGame.id_multiplicator = multiplicatorId

                                        console.log(dataAddGame)

                                        blockAddMultiplicator.classList.remove('intro-y')
                                        blockMultiplicator.classList.remove('intro-y')
                                        blockAddMultiplicator.classList.add('animate__fadeOutDown')
                                        blockMultiplicator.classList.add('animate__fadeOutDown')

                                        setTimeout(function(){
                                            blockAddMultiplicator.style.display = "none"
                                            blockMultiplicator.style.display = "none"

                                            let rankedButtons = document.getElementById('rankedButtons')

                                            let tabRankedId = []
                                            let tabRankedPositions = []
                                            responseRanked.forEach(element => tabRankedId.push(element.id));
                                            responseRanked.forEach(element => tabRankedPositions.push(element.position));


                                            blockAddRanked.style.display = 'block'
                                            blockRanked.style.display = 'block'

                                            for (i = 0; i < tabRankedPositions.length; i++) {
                                                let button = document.createElement("button");
                                                button.classList.add('paste')
                                                button.id = tabRankedId[i]
                                                button.innerText = tabRankedPositions[i]

                                                button.onclick = function (){
                                                    ajaxPost('/user/user_create_game', rankedId, function (response){


                                                        blockAddRanked.classList.remove('intro-y')
                                                        blockRanked.classList.remove('intro-y')
                                                        blockAddRanked.classList.add('animate__fadeOutDown')
                                                        blockRanked.classList.add('animate__fadeOutDown')
                                                        setTimeout(function(){
                                                            blockAddRanked.style.display = "none"
                                                            blockRanked.style.display = "none"

                                                            blockConfirmAddGame.style.display = 'block'
                                                            blockConfirmAddGameButton.style.display = 'block'

                                                        }, 300)

                                                        }

                                                    )}

                                                let rankedId = tabRankedId[i]


                                                rankedButtons.appendChild(button)
                                            }

                                        }, 300);

                                    })
                                }

                                let multiplicatorId = tabMultiplicatorId[i]

                                multiplicatorButtons.appendChild(button)


                            }


                        }, 300);

                    })


                }
                buyButtons.appendChild(button)
            }



        }, 300);


    })


}