<template>
    <video id="video" class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9"
           controls preload="auto" data-setup='{"fluid": true, "preload": "auto"}' v-bind:poster="thumbnailUrl">
        <source v-bind:src="videoUrl" type="video/mp4" />
    </video>
</template>
<script>
    import videojs from "video.js";

    export default {
        data() {
            return {
                player: null,
            }
        },
        props: {
            videoUid: null,
            videoUrl: null,
            thumbnailUrl: null,
        },
        mounted() {
            this.player = videojs('video');
        }
    }
</script>