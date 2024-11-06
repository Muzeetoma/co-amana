const Ziggy = {"url":"http:\/\/localhost:8080","port":8080,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"home":{"uri":"\/","methods":["GET","HEAD"]},"login":{"uri":"api\/login","methods":["POST"]},"order.create":{"uri":"api\/order","methods":["POST"]},"order":{"uri":"api\/order\/{limit}","methods":["GET","HEAD"],"parameters":["limit"]},"products":{"uri":"api\/products\/{limit}","methods":["GET","HEAD"],"wheres":{"limit":"[0-9]+"},"parameters":["limit"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
