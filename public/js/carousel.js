/* ─────────────────────────────────────────────────────────
   Multi-Item Carousel:
   - Infinite rotation by default (products, collections)
   - Bounded scroll when data-loop="false" (e.g. Testimonials ending in VIEW ALL)
   Called via onclick="mcScroll('trackId', 1/-1)"
───────────────────────────────────────────────────────── */
const mcAnimating = {};
const mcScrollPos = {};

function mcScroll(trackId, dir) {
  const track = document.getElementById(trackId);
  if (!track || mcAnimating[trackId]) return;

  const isInfinite = track.getAttribute('data-loop') !== 'false';
  const items = track.querySelectorAll('.mc-item');
  if (items.length <= 1) return;

  const firstItem = items[0];
  const style = window.getComputedStyle(track);
  const gap = parseFloat(style.gap) || parseFloat(style.columnGap) || 16;
  const cardWidth = firstItem.getBoundingClientRect().width + gap;

  if (isInfinite) {
    // ── INFINITE CIRCULAR ROTATION ──
    mcAnimating[trackId] = true;
    if (dir === 1) {
      track.style.transition = 'transform 0.35s cubic-bezier(0.25, 1, 0.5, 1)';
      track.style.transform = `translateX(-${cardWidth}px)`;

      const onEnd = function () {
        track.removeEventListener('transitionend', onEnd);
        track.style.transition = 'none';
        track.appendChild(track.firstElementChild);
        track.style.transform = 'none';
        void track.offsetHeight;
        mcAnimating[trackId] = false;
      };

      track.addEventListener('transitionend', onEnd, { once: true });
      setTimeout(() => {
        if (mcAnimating[trackId]) onEnd();
      }, 400);
    } else {
      const lastItem = track.lastElementChild;
      track.style.transition = 'none';
      track.insertBefore(lastItem, track.firstElementChild);
      track.style.transform = `translateX(-${cardWidth}px)`;
      void track.offsetHeight;

      track.style.transition = 'transform 0.35s cubic-bezier(0.25, 1, 0.5, 1)';
      track.style.transform = 'translateX(0)';

      const onEnd = function () {
        track.removeEventListener('transitionend', onEnd);
        track.style.transition = 'none';
        track.style.transform = 'none';
        void track.offsetHeight;
        mcAnimating[trackId] = false;
      };

      track.addEventListener('transitionend', onEnd, { once: true });
      setTimeout(() => {
        if (mcAnimating[trackId]) onEnd();
      }, 400);
    }
  } else {
    // ── BOUNDED LINEAR SCROLL (NO REPEAT OF FIRST CARD) ──
    if (typeof mcScrollPos[trackId] === 'undefined') {
      mcScrollPos[trackId] = 0;
    }

    const containerWidth = track.parentElement.clientWidth;
    const totalWidth = items.length * cardWidth - gap;
    const maxOffset = Math.max(0, totalWidth - containerWidth);

    if (maxOffset <= 0) return; // All cards already visible

    let nextPos = mcScrollPos[trackId] + dir * cardWidth;
    if (nextPos < 0) nextPos = 0;
    if (nextPos > maxOffset) nextPos = maxOffset;

    if (Math.abs(nextPos - mcScrollPos[trackId]) < 1) return; // Already at boundary

    mcAnimating[trackId] = true;
    mcScrollPos[trackId] = nextPos;

    track.style.transition = 'transform 0.35s cubic-bezier(0.25, 1, 0.5, 1)';
    track.style.transform = `translateX(-${nextPos}px)`;

    const onEnd = function () {
      track.removeEventListener('transitionend', onEnd);
      mcAnimating[trackId] = false;
    };

    track.addEventListener('transitionend', onEnd, { once: true });
    setTimeout(() => {
      if (mcAnimating[trackId]) onEnd();
    }, 400);
  }
}

// Reset bounded scroll positions on window resize
window.addEventListener('resize', () => {
  document.querySelectorAll('.mc-track[data-loop="false"]').forEach((track) => {
    track.style.transition = 'none';
    track.style.transform = 'none';
    mcScrollPos[track.id] = 0;
  });
});
