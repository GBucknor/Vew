<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Upload a video</div>

                    <div class="card-body">
                        <input type="file" name="video" id="video" v-if="!uploading" @change="fileInputChange">
                        <div class="alert alert-danger" v-if="failed">There was a problem during the file upload. Please refresh the page.</div>
                        <div id="v-form" v-if="uploading && !failed">
                            <div class="progress" v-if="!uploadingComplete">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" v-bind:style="{width: fileProgress + '%'}"></div>
                            </div>
                            <br/>
                            <div class="alert alert-info" v-if="!uploadingComplete">
                                Your video is now being uploaded. It will be available at <a :href="$root.url/'videos'/uid " target="_blank">{{$root.url}}/videos/{{ uid }}.</a>
                            </div>
                            <div class="alert alert-success" v-if="uploadingComplete">Video uploaded. It is now being processed. <a href="/videos">Go to video list.</a> </div>

                            <div class="form-group">
                                <label for="video-title">Title</label>
                                <input name="video-title" id="video-title" v-model="title" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="video-description">Description</label>
                                <textarea id="video-description" name="video-description" v-model="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="video-accessibility">Description</label>
                                <select id="video-accessibility" name="video-accessibility" v-model="access" class="form-control">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>

                            <span class="form-text float-right">{{ saveStatus }}</span>
                            <button class="btn btn-outline-secondary" type="submit" @click.prevent="update">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                uid: null,
                title: 'Untitled',
                description: null,
                access: 'private',
                uploading: false,
                uploadingComplete: false,
                failed: false,
                saveStatus: null,
                fileProgress: 0
            }
        },
        methods: {
            fileInputChange() {
                // Starts the uploading process, but also indicates that the process
                // hasn't failed yet.
                this.uploading = true;
                this.failed = false;
                this.file = document.getElementById('video').files[0];
                // Stores metadata
                this.store().then(() => {
                    let form = new FormData();
                    form.append('video', this.file);
                    form.append('uid', this.uid);
                    axios.post('/upload', form, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: (progressEvent) => {
                            if (progressEvent.lengthComputable) {
                                this.updateProgress(progressEvent);
                            }
                        }
                    }).then( () => {
                        this.uploadingComplete = true;
                    }).catch(() => {
                        this.failed = true;
                    });
                }).catch(() => {
                    this.failed = true;
                });
            },
            store() {
                return axios.post('/videos', {
                    title: this.title,
                    description: this.description,
                    access: this.access,
                    extension: this.file.name.split('.').pop(),
                }).then((response) => {
                    this.uid = response.data.data.uid;
                });
            },
            update() {
                this.saveStatus = 'Saving changes';
                return axios.put('/videos/' + this.uid, {
                    title: this.title,
                    description: this.description,
                    access: this.access,
                }).then((response) => {
                    this.saveStatus = 'Changes saved';
                    setTimeout(() => {
                        this.saveStatus = null
                    }, 4000)
                }, () => {
                    this.saveStatus = 'Failed to save changes';
                });
            },
            updateProgress(e) {
                e.percent = Math.round((e.loaded * 100) / e.total);
                this.fileProgress = e.percent;
            }
        },
        mounted() {
            //
        }
    }
</script>
