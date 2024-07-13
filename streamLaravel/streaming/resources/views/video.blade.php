@extends('layout.main')

<main>
    <div class="contentVideo">
        <div class="vdo-container" id="host">
            <div style="overflow: hidden; height: 100%; width: 100%">
                <iframe allowfullscreen="true" allow="autoplay; encrypted-media" frameborder="0"
                    src="https://player.vdocipher.com/v2/?otp=20160313versASE323dGpe6LSVhL3VpJ77dQ7wmuN9qMu9AQ1xkc4w5U0GONPII4&playbackInfo=eyJ2aWRlb0lkIjoiOGMxOGQzZTFlZmI0NDExNmI2NTkwYmI4ZDJmZWJmNjUifQ=="
                    style="height: 100%; width: 100%; overflow: auto"></iframe>
            </div>
        </div>
        <div id="response-display" class="response hide"></div>
    </div>
</main>
