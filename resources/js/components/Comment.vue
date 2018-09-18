<template>
  <div class="comment">
    <div class="comment-body">{{ comment.blog_comment }}</div>
    <div class="date">{{ commentDate }}</div>
  </div>
</template>

<script>
const format = require('date-fns').format;

module.exports = {
  name: 'comment',
  props: {
    comment: Object
  },
  computed: {
    commentDate: function () {
      return format(this.comment.created_at, 'dddd, MMMM D, YYYY h:mm A');
    }
  }
};
</script>

<style lang="scss">
  .comments {
    .comment {
      padding: 10px;
      border: 1px solid #d8d8d8;
      margin-bottom: 15px;

      &:last-child {
        margin-bottom: 0;
      }

      .comment-body {
        margin-bottom: 5px;
      }

      .date {
        font-size: 13px;
        color: #7d7d7d;
      }
    }
  }
</style>
