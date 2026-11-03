import {defineConfig} from "vite";
import typo3 from "vite-plugin-typo3";
import {viteStaticCopy} from "vite-plugin-static-copy";

export default defineConfig({
  plugins: [
    typo3({target: "extension"}),
    viteStaticCopy({
      targets: [
        {
          src: "node_modules/@fortawesome/fontawesome-free/svgs",
          dest: "../Icons/FontAwesome",
          rename: { stripBase: 4 }
        },
        {
          src: "node_modules/ionicons/dist/ionicons/svg",
          dest: "../Icons/Ionicons",
          rename: { stripBase: true }
        },
      ],
    }),
  ],
  build: {
    cssCodeSplit: true,
  }
});
