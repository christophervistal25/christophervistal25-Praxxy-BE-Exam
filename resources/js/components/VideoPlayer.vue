<template>
  <div id="my-video-player">
    <video ref="videoPlayer" class="video-js vjs-default-skin"></video>
  </div>
</template>

<script>
import 'video.js/dist/video-js.css';
import videojs from 'video.js';

export default {
  name: 'VideoPlayer',
  props: {
    videoUrl: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      player: null,
      options: {
        controls: true,
      }
    };
  },
  mounted() {
    this.player = videojs(this.$refs.videoPlayer, this.options, function onPlayerReady() {
      console.log('Player ready');
    });

    this.player.src(this.videoUrl);
  },
  watch: {
    videoUrl: function (newVal, oldVal) {
      this.player.src(newVal);
    }
  }
};
</script>