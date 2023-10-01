// script.js
document.addEventListener("DOMContentLoaded", () => {
    const key = document.querySelector(".key");
    const keyhole = document.querySelector(".keyhole");
    const ghost = document.querySelector(".ghost");
  
    // Timeout to introduce the key and keyhole
    setTimeout(() => {
        key.style.animationPlayState = "running";
        keyhole.style.animationPlayState = "running";
    }, 1000); // Adjust the delay as needed
  
    // Function to grant access
    const grantAccess = () => {
        key.parentElement.parentElement.style.cursor = "default";
        keyhole.style.display = "none";
        key.style.display = "none";
        ghost.style.display = "none";
    };
  
    // Mouseover event on the keyhole
    keyhole.addEventListener("mouseover", grantAccess);
  
    // Mousemove event to move the key with the cursor
    document.addEventListener("mousemove", (e) => {
        key.style.left = e.clientX - key.clientWidth / 2 + "px";
        key.style.top = e.clientY - key.clientHeight / 2 + "px";
    });
});
