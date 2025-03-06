class Stratagem{
    constructor(name, sequence){
        this.name = name;
        this.sequence = sequence;
        this.currentIndex = 0;
    }
}

let stratagemList = []
let stratagemData = PATRIOTIC_ADMINISTRATION_CENTER.concat(
    ORBITAL_CANNONS, 
    HANGER, 
    BRIDGE, 
    ENGINEERING_BAY, 
    ROBOTICS_WORKSHOP, 
    GENERAL_STRATEGEMS
);
let currentStratagem;

//Preload images
const arrowPreloadImages = [
    "downArrow", "downArrowDone", 
    "leftArrow", "leftArrowDone", 
    "rightArrow", "rightArrowDone", 
    "upArrow", "upArrowDone"
];
let images = [];
for (i = 0; i < arrowPreloadImages.length; i++) {
    images[i] = new Image();
    images[i].src = `/resources/images/arrows/${arrowPreloadImages[i]}.png`;
}

stratagemData.forEach(element => {
    let stratagem = new Stratagem(element.name, element.code);
    stratagemList.push(stratagem);
});

const controls = {
    "left": ["a", "ArrowLeft"],
    "up": ["w", "ArrowUp"],
    "down": ["s", "ArrowDown"],
    "right": ["d", "ArrowRight"]
}

const deleteChildren = (parent) => {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

const updateSequence = () => {
    const sequenceElement = document.getElementById("sequence");
    let isActivated;
    deleteChildren(sequenceElement);
    for(let i = 0; i < currentStratagem.sequence.length; i++) {
        i < currentStratagem.currentIndex? isActivated = true : isActivated = false
        let arrow = document.createElement("img");
        switch(currentStratagem.sequence[i]) {
            case "left":
                arrow.src = `/resources/images/arrows/${isActivated? "leftArrowDone" : "leftArrow"}.png`
                break;
            case "up":
                arrow.src = `/resources/images/arrows/${isActivated? "upArrowDone" : "upArrow"}.png`
                break;
            case "down":
                arrow.src = `/resources/images/arrows/${isActivated? "downArrowDone" : "downArrow"}.png`
                break;
            case "right":
                arrow.src = `/resources/images/arrows/${isActivated? "rightArrowDone" : "rightArrow"}.png`
                break;
        }
        sequenceElement.appendChild(arrow);
    }
}

const newStratagem = () => {
    currentStratagem = stratagemList[Math.floor(Math.random() * stratagemList.length)];
    currentStratagem.currentIndex = 0;
    document.getElementById("name").innerHTML = currentStratagem.name;
    document.getElementById("img").src = `/resources/images/stratagems/${currentStratagem.name.replace(/['"]+/g, '')}.svg`;
    document.getElementById("img").alt = currentStratagem.name;
    updateSequence();
}

const error = () => {
    currentStratagem.currentIndex = 0;
    updateSequence();
    document.getElementById("sequence").classList.add("apply-shake")
}

document.getElementById("sequence").addEventListener("animationend", (e) => {
    document.getElementById("sequence").classList.remove("apply-shake");
});

document.body.addEventListener("keydown", (event) => {
    if(!Object.values(controls).flat(1).includes(event.key)) return;
    if(controls[currentStratagem.sequence[currentStratagem.currentIndex]].includes(event.key)){
        currentStratagem.currentIndex++;
        if(currentStratagem.sequence.length == currentStratagem.currentIndex){
            setTimeout(newStratagem, 200);
        }
        updateSequence();
    } else {
        error();
    }
})

newStratagem();