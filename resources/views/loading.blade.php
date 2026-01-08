<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Loading</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #ffffff;
    overflow: hidden;
}

/* SCENE */
#scene {
    position: fixed;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: opacity 1.2s ease, transform 1.2s ease;
}

#scene.fade-out {
    opacity: 0;
    transform: scale(1.05);
}

/* RING WRAPPER */
.ring-wrapper {
    position: relative;
    width: 200px;
    height: 200px;
}

/* BASE RING */
.ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 4px solid transparent;
    animation:
        spin 6s linear infinite,
        colorShift 4.5s ease-in-out infinite,
        drift 3.5s ease-in-out infinite;
}

/* RING VARIANTS */
.ring.one {
    border-top-color: #A376A2;
    animation-duration: 6s;
}

.ring.two {
    border-right-color: #A376A2;
    animation-duration: 4.5s;
    animation-direction: reverse;
    animation-delay: 0.5s;
}

.ring.three {
    border-bottom-color: #A376A2;
    animation-duration: 7s;
    animation-delay: 1s;
}

/* TEXT */
h1 {
    margin-top: 36px;
    font-size: 26px;
    font-weight: 600;
    animation: colorShift 4.5s ease-in-out infinite;
}

p {
    margin-top: 12px;
    font-size: 14px;
    letter-spacing: 1px;
    color: #777;
}

/* ANIMATIONS */
@keyframes spin {
    to { transform: rotate(360deg); }
}

@keyframes drift {
    0%   { transform: translate(0, 0); }
    25%  { transform: translate(-8px, 6px); }
    50%  { transform: translate(6px, -8px); }
    75%  { transform: translate(-6px, -4px); }
    100% { transform: translate(0, 0); }
}

@keyframes colorShift {
    0% {
        border-color: #A376A2;
        color: #A376A2;
    }
    33% {
        border-color: #D64545; /* merah */
        color: #D64545;
    }
    66% {
        border-color: #E6C84F; /* kuning */
        color: #E6C84F;
    }
    100% {
        border-color: #A376A2;
        color: #A376A2;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const subtitle = document.getElementById("subtitle");
    const scene = document.getElementById("scene");

    setTimeout(() => subtitle.innerText = "Preparing Laboratory Data", 3000);
    setTimeout(() => subtitle.innerText = "Finalizing Configuration", 6000);

    setTimeout(() => scene.classList.add("fade-out"), 8000);

    setTimeout(() => {
        window.location.href = "/login";
    }, 9000);
});
</script>
</head>

<body>

<div id="scene">

    <div class="ring-wrapper">
        <div class="ring one"></div>
        <div class="ring two"></div>
        <div class="ring three"></div>
    </div>

    <h1>Loading</h1>
    <p id="subtitle">Initializing System</p>

</div>

</body>
</html>
