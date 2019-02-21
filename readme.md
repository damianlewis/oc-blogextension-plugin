# Blog Extension
This plugin is an extension to the [RainLab.Blog](https://github.com/rainlab/blog-plugin) plugin.

### Latest Posts
The `blogLatestPosts` component can be used to display a static list of latest posts. It's useful for sidebars etc, when you want the same posts displayed across multiple pages when using pagination.
- **numberOfPosts** - How many posts to display. The default value is 5.
- **postPage** - The name of the blog post details page. The default is `blog/post`.
- **exceptPost** - Ignore a single post by either its slug or ID.

The blogLatestPosts component injects the following variables into the page where it's used:
- **latestPosts** - A list of latest blog posts loaded from the database.
