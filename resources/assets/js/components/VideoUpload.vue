<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        <input type="file" name="video" id="video" v-if="!uploading" @change="fileInputChange">

                        <div id="v-form" v-if="uploading && !failed">
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
                saveStatus: null
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
                    //
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
                }).catch((err) => {
                    console.log(err);
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
                }).catch(err => {
                    console.log(err);
                });
            }
        },
        mounted() {
            //
        }
    }
</script>
