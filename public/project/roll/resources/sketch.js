let player, viewer, world;
let obstacles = [];
let obstacleNum = 4;

let rayX = 0;
let rayZ = 0;
let fov = 1600;

let rayInvert = false;
let xzAngle = 0;

let clock = 0;
let length = 120;
let interval;
let started = false;
let ended = false;

let bg = [168, 241, 255];
let bgw = [168, 241, 255];
let bgw_dir = ['up', 'up', 'up'];
let bgw_bor = [180, 240];
let lamp = [120, 120, 90];

let nightMode = false;

// DOM functions

// Start the game
$(document).on('click', '#startBtn', function() {
    // Enable the renderer
    started = true;
    // Set the game length to the user input value
    length = $('#len_box').val();

    // Start the clock cycle
    interval = setInterval(function() {
       if(clock < length) {
           // Increment the clock value
           clock++;
           // Display the clock
           $('#clock').html(Math.floor(clock / 60)+':'+('0'+(clock % 60)).slice(-2));
           // Transition to the end screen background in time for the game end
           if(clock === length - 5) {
               bgw = bg;
           }

       } else {
           clearInterval(interval);
       }
    }, 1000);
});

// P5 functions
function setup() {
    // Initialize the canvas at screen size
    createCanvas(windowWidth, (windowHeight - 100), WEBGL);
    angleMode(DEGREES);

    // Create a background for the splash screen
    background(bgw);

    // Create the World
    world = new World(fov, 200);

    // Initialize the World
    world.init();

    // Create the Player
    player = new Player(fov);

    // Create a camera, the Viewer
    viewer = createCamera();
    calibrateViewer();
    viewer.tilt(40);
}

function draw() {
    if(started && clock < length) {
        // Draw the background
        if(nightMode) {
            if(bg[0] > 1) {
                bg[0] -= 2;
            }
            if(bg[1] > 36) {
                bg[1] -= 2
            }
            if(bg[2] > 92) {
                bg[2] -= 2
            }
            if(lamp[0] < 207) {
                lamp[0] += 2;
            }
            if(lamp[1] < 139) {
                lamp[1] += 2
            }
            if(lamp[2] < 193) {
                lamp[2] += 2
            }
        }

        // Color the background dynamically
        background(bg);

        // Light it up!
        ambientLight(120, 120, 80);

        // Calculate sun position
        let lampX = (0.999 * player.position.x) - 40;
        let lampZ = (0.999 * player.position.z) + 40;
        pointLight(lamp, lampX, -1000, lampZ);

        // Draw the world
        world.draw();

        // Draw the obstacles on the world
        for (let i = 0; i < obstacles.length; i++) {
            obstacles[i].draw();
        }

        // Transition to night at halftime
        if(clock === Math.floor(length / 2) && !nightMode) {
            nightMode = true;
            bgw_bor = [1, 80];
        }

        // Detect key changes
        handleKeys();

        // Move the player orb
        player.move();
        // Rotate the player orb
        player.rotate();

        if(clock > length - 5 && !player.selfControlled) {
            player.selfControlled = true;
        }
    } else {
        for(let i = 0; i < bgw.length; i++) {
            let amt = Math.floor(random(0, 2));

            if(bgw_dir[i] === 'down') {
                bgw[i] -= amt;
                if(bgw[i] <= bgw_bor[0]) {
                    bgw_dir[i] = 'up';
                }
            } else if(bgw_dir[i] === 'up') {
                bgw[i] += amt;
                if(bgw[i] > bgw_bor[1]) {
                    bgw_dir[i] = 'down';
                }
            }
        }
        background(bgw);
    }
}

// Functions n all, yay
function calibrateViewer() {
    // Function that calibrates the Viewer to always have the Player centered.
    let focus = player.position;

    if(!player.selfControlled) {
        // calculate position around radius
        let z = 300 * Math.sin(xzAngle * Math.PI / 180);
        let x = 300 * Math.cos(xzAngle * Math.PI / 180);

        viewer.setPosition(focus.x + x, focus.y - 200, focus.z + z);
    }
    viewer.lookAt(focus.x, focus.y, focus.z);
}

function handleKeys() {
    // Handles user key input
    if(!player.selfControlled) {
        if (keyIsDown(LEFT_ARROW)) {
            player.spin('left');
            player.spinertia();
        }
        if (keyIsDown(RIGHT_ARROW)) {
            player.spin('right');
            player.spinertia();
        }
        if (keyIsDown(UP_ARROW)) {
            player.direction = 'up';
            player.inertia();
            player.powered = true;
        }
        if (keyIsDown(DOWN_ARROW)) {
            player.direction = 'down';
            player.inertia();
            player.powered = true;
        }

        if (!keyIsPressed) {
            // Decreases the player speed exponentially, for a smooth stop
            player.powered = false;
            if (player.speed > 0) {
                player.speed = player.speed * Math.pow(0.99, player.speed + 0.5);
                if (player.speed < 0.1) {
                    player.speed = 0;
                }
            } else if (player.speed < 0) {
                player.speed = player.speed * Math.pow(0.99, -1 * (player.speed) + 0.5);
                if (player.speed > -0.1) {
                    player.speed = 0;
                }
            }
            if (player.spinSpeed > 0) {
                player.spinSpeed -= 0.5;
            } else if (player.spinSpeed < 0) {
                player.spinSpeed += 0.5;
            }
        }
    }
}