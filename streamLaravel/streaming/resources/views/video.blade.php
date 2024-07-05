@extends('layout.main')

<main>
    <div class="contentVideo">
        <div class="vdo-container" id="host">
            <div style="overflow: hidden; height: 100%; width: 100%">
                <iframe allowfullscreen="true" allow="autoplay; encrypted-media" frameborder="0"
                    src="https://player.vdocipher.com/v2/?otp=20160313versASE313c63a68c96144b8d770464f6bac27531b38825875e952ca&playbackInfo=eyJ2aWRlb0lkIjoiMTA0MWVkNThjZDU0NGY5YmE2MGEzYWE1ZGEzZjExZWYifQ=="
                    style="height: 100%; width: 100%; overflow: auto"></iframe>
            </div>
        </div>
        <div id="response-display" class="response hide"></div>
    </div>
</main>
