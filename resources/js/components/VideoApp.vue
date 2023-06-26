<template>
    <div class="px-3">
        <div class="row">
            <div class="col-auto">
                <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 380px;">
                    <a href="/"
                        class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                        <span class="fs-5 fw-semibold">Videos</span>
                    </a>
                    <div class="list-group list-group-flush border-bottom scrollarea">
                        <div v-for="(link, index) in videoLinks" :key="index">
                            <a style="cursor:pointer;" @click="openVideo(link)"
                                class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <strong class="mb-1">{{ link.split('/').pop() }}</strong>
                                </div>
                                <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and
                                    date.</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <video-player :video-url="selectedUrl"></video-player>
            </div>
        </div>
    </div>
</template>
<script>
import { ref, watch } from "vue";
export default {
    setup() {
        const selectedUrl = ref("");

        const videoLinks = ref([
            '/storage/videos/video1.mp4',
            '/storage/videos/video2.mp4',
        ]);

        selectedUrl.value = videoLinks.value[0];

        const openVideo = (link) => {
            selectedUrl.value = link;
        };


        return {
            videoLinks,
            openVideo,
            selectedUrl
        };
    },
};
</script>