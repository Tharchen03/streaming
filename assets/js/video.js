/* global VdoPlayer */

const iframe = document.querySelector("iframe");
const player = new VdoPlayer(iframe);
const btn = document.querySelector("#btn");
console.log(btn);
player.video.addEventListener("timeupdate", () => {
  const { currentTime } = player.video;
  if (currentTime > 10 && currentTime < 600) {
    return btn.classList.remove("hide");
  } else {
    btn.classList.add("hide");
  }
});
