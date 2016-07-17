var svgns = "http://www.w3.org/2000/svg";

function Piece(board,player,cellRow,cellCol,type,num){

    console.log("board : " + board + " player : " + player + " cellRow : " + cellRow + " : " + " cellCol : " + cellCol +  " type: " + type + " num: " + num);
    this.board = board;
    this.player = player;
    this.type = type;
    this.currentCell = boardArr[cellRow][cellCol];
    this.number = num;
    this.isCaptured = false;

    this.id = "piece_" + this.player + "|" + this.number;
    this.currentCell.isOccupied(this.id);
    this.x = this.currentCell.getCenterX();
    this.y = this.currentCell.getCenterY();

    // this.object=new window[type](this);
    this.object = eval("new " + type + "(this)");

    this.piece = this.object.piece;
    this.setAtt("id",this.id);
    if(this.player == playerId){
        // this.piece.addEventListener('mousedown',function(){ setMove(this.id);},false);	// add a mousedown event listener to your piece so that it can be dragged.
    }else{
        this.piece.addEventListener('mousedown',nypwarning,false);	//tell the user that isn't his piece!
    }
    document.getElementsByTagName('svg')[0].appendChild(this.piece);
    return this;
}

Piece.prototype.setAtt = function(att,val){
    this.piece.setAttributeNS(null,att,val);
};

Piece.prototype.changeCell = function(newCell,row,col){
    this.currentCell.notOccupied();
    document.getElementById('output').firstChild.nodeValue = 'dropped cell: ' + newCell;
    this.currentCell = boardArr[row][col];
    this.currentCell.isOccupied(this.id);
};
Piece.prototype.putOnTop = function(){
    document.getElementsByTagName('svg')[0].removeChild(this.piece);
    document.getElementsByTagName('svg')[0].appendChild(this.piece);
};

function Checker(parent){
    this.parent = parent;
    this.isKing = false;
    this.piece = document.createElementNS(svgns,"g");
    if(this.parent.player == playerId){
        this.piece.setAttributeNS(null,"style","cursor:pointer");
    }
    this.piece.setAttributeNS(null,"transform","translate("+this.parent.x+","+this.parent.y+")");


    var circ = document.createElementNS("http://www.w3.org/2000/svg","circle");
    circ.setAttributeNS(null,"r",'26');
    circ.setAttributeNS(null,"class",'player' + this.parent.player);					// change the color according to player
    this.piece.appendChild(circ);
    return this;
}