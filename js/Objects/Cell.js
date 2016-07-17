function Cell(myParent, id, size, col, row) {
    this.parent = myParent;
    this.id = id;
    this.size = size;
    this.col = col;
    this.row = row;

    this.occupied = '';
    this.state = 'alive';
    this.x = this.col * this.size;
    this.y = this.row * this.size;

    this.color = 'white';
    this.droppable = (((this.row + this.col) % 2) == 0) ? true : false;

    this.object = this.createIt();
    this.object.addEventListener('click', function () {
        dropCheck(col);
    }, false);

    this.parent.appendChild(this.object);
    this.myBBox = this.getMyBBox();
}

Cell.prototype.createIt = function () {
    var col = this.col;
    var gEle = document.createElementNS(svgns, 'g');
    gEle.setAttributeNS(null, 'transform', 'translate(' + this.x + ',' + this.y + ')');
    gEle.setAttributeNS(null, 'id', this.id);
    gEle.setAttributeNS(null, 'class', 'cell');

    var rect = document.createElementNS(svgns, 'rect');
    rect.setAttributeNS(null, 'width', this.size + 'px');
    rect.setAttributeNS(null, 'height', this.size + 'px');
    rect.setAttributeNS(null, 'x', 0 + 'px');
    rect.setAttributeNS(null, 'y', 0 + 'px');
    rect.setAttributeNS(null, 'class', 'cell_' + 'black');

    var circ = document.createElementNS(svgns, 'circle');
    circ.setAttributeNS(null, 'r', ((this.size / 2) - 10) + 'px');
    circ.setAttributeNS(null, 'cx', (this.size / 2) + 'px');
    circ.setAttributeNS(null, 'cy', (this.size / 2) + 'px');
    circ.setAttributeNS(null, 'class', 'cell_' + 'white');

    var text = document.createElementNS(svgns,'text');
    text.setAttributeNS(null,'x',(this.size / 6) + 'px');
    text.setAttributeNS(null,'y',(this.size / 2) + 'px');
    var textNode = document.createTextNode(this.id);
    text.appendChild(textNode);

    gEle.appendChild(rect);
    gEle.appendChild(circ);
    gEle.appendChild(text);

    return gEle;
};

Cell.prototype.getMyBBox = function () {
    return this.object.getBBox();
};

Cell.prototype.getCenterX = function () {
    return (BOARDX + this.x + (this.size / 2));
};

Cell.prototype.getCenterY = function () {
    return (BOARDY + this.y + (this.size / 2));
};

Cell.prototype.isOccupied = function (pieceId) {
    this.occupied = pieceId;
    this.changeFill('alert');
};

Cell.prototype.notOccupied = function () {
    this.occupied = '';
    this.changeFill(this.color);
};

Cell.prototype.changeFill = function (toColor) {
    document.getElementById(this.id).setAttributeNS(null, 'class', 'cell_' + toColor);
};