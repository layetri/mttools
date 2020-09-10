class Obstacle {
    constructor(xBounds, zBounds) {
        this.s = random(20, 50);

        let half = this.s / 2;
        this.x = random(xBounds[0] + half, xBounds[1] - half);
        this.z = random(zBounds[0] + half, zBounds[1] - half);
        this.y = world.getCurrentY(this.x, this.z) - half;
        this.c = [random(0, 255), random(0,255), random(0,255)];

        let typelst = ['static', 'moving'];
        this.type = typelst[Math.floor(random(0,2))];
        this.initPos = {x: this.x, y: this.y, z: this.z};
        this.range = {x: random(50, 350), z: random(0, 350)};
        this.xSpeed = random(0,5);
        this.zSpeed = random(0,5);
    }
    draw() {
        this.gravity();
        if(this.type === 'moving') {
            this.move();
        }

        push();
        rectMode(CENTER);
        translate(this.x, this.y, this.z);
        fill(this.c);
        box(this.s);
        pop();
    }
    move() {
        let xbnd = [this.initPos.x - (this.range.x / 2), this.initPos.x + (this.range.x / 2)];
        let zbnd = [this.initPos.z - (this.range.z / 2), this.initPos.z + (this.range.z / 2)];

        this.x += this.xSpeed;
        this.z += this.zSpeed;

        if(this.x > xbnd[1] || this.x < xbnd[0]) {
            this.xSpeed = this.xSpeed * -1;
        }
        if(this.z > zbnd[1] || this.z < zbnd[0]) {
            this.zSpeed = this.zSpeed * -1;
        }
    }
    gravity() {
        if(this.y + (this.s / 2) > world.getCurrentY(this.x, this.z)) {
            this.y -= this.speed;
        }
    }
}