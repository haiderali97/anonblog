<template>
  <div class="post">
    <div class="title">
      <a :href="postUrl">
        <h2>{{ post.blog_title }}</h2>
      </a>
    </div>
    <div class="date">
      <span><i class="fa fa-clock-o"></i> Published on {{ publishedDate }}</span>
      <span v-if="post.created_at !== post.updated_at"><i class="fa fa-pencil"></i> Edited on {{ updatedDate }}</span>
    </div>
    <div class="text-content">
      {{ description }}
    </div>
    <div class="read-more">
      <a :href="postUrl" class="btn btn-primary">Read more...</a>
    </div>
  </div>
</template>

<script>
const format = require('date-fns').format;

const truncate = (str, len) => {
  return str.length > len
    ? `${ str.slice(0, len) }...`
    : str;
};

module.exports = {
  name: 'post',
  props: {
    post: Object
  },
  computed: {
    description: function () {
      return truncate(this.post.blog_post, 300);
    },
    postUrl: function () {
      return `/${this.post.id}/${this.post.slug}`;
    },
    publishedDate: function () {
      return format(this.post.created_at, 'dddd, MMMM D, YYYY h:mm A');
    },
    updatedDate: function () {
      return format(this.post.updated_at, 'dddd, MMMM D, YYYY h:mm A');
    }
  }
};
</script>

<style lang="scss">
  $fa-font-path: "~font-awesome/fonts";
  @import '~font-awesome/scss/font-awesome.scss';

  .posts-list {
    .post {
      padding: 15px;
      margin-bottom: 20px;
      border-bottom: 1px solid #d8d8d8;

      &:last-child {
        margin-bottom: 0;
        border-bottom: 0;
      }

      .read-more {
        padding: 0 5px;
        text-align: right;
      }

      .date {
        margin-bottom: 10px;
        font-size: 13px;
        color: #7d7d7d;

        span {
          margin-right: 10px;

          &:last-child {
            margin-right: 0;
          }
        }
      }
    }
  }
</style>

