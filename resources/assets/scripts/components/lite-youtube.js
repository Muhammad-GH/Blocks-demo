export default async function init() {
  return await Promise.all([
    import(/* webpackChunkName: "components/lite-youtube" */ 'lite-youtube-embed'),
    import(/* webpackChunkName: "components/lite-youtube" */ 'lite-youtube-embed/src/lite-yt-embed.css'),
  ]);
}
