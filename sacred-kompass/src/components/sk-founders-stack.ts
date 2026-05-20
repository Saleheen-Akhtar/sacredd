import { LitElement, html, css } from 'lit';
import { customElement, property, state } from 'lit/decorators.js';
import { gsap } from 'gsap';

interface Founder {
  title: string;
  role: string;
  image: string;
  bio: string;
}

@customElement('sk-founders-stack')
export class SkFoundersStack extends LitElement {
  @property({ type: Array }) founders: Founder[] = [];
  @state() private activeIndex = -1;

  static styles = css`
    :host {
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      perspective: 1000px;
    }
    .deck {
      position: relative;
      width: 300px;
      height: 400px;
      transform-style: preserve-3d;
    }
    .card {
      position: absolute;
      inset: 0;
      background: var(--sk-earth);
      color: var(--sk-cream);
      border-radius: 8px;
      padding: var(--sk-space-md);
      cursor: pointer;
      transform-origin: bottom center;
      will-change: transform, opacity;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 4px;
      margin-bottom: var(--sk-space-sm);
    }
    .card h3 {
      font-family: var(--sk-font-display);
      font-size: var(--fs-h3);
      margin: 0;
      color: var(--sk-gold);
    }
    .card p.role {
      font-family: var(--sk-font-eyebrow);
      font-size: var(--fs-eyebrow);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: var(--sk-space-sm);
    }
    .card p.bio {
      font-family: var(--sk-font-body);
      font-size: var(--fs-body-sm);
      color: var(--sk-cream-30);
      opacity: 0;
      transition: opacity var(--dur-fast) var(--ease-out);
    }
    .card.active p.bio {
      opacity: 1;
    }
  `;

  firstUpdated() {
    this.fanCards();
  }

  fanCards() {
    const cards = this.shadowRoot?.querySelectorAll('.card');
    if (!cards) return;

    gsap.to(cards, {
      rotationZ: (i) => (i - this.founders.length / 2) * 10,
      y: (i) => Math.abs(i - this.founders.length / 2) * 20,
      z: (i) => i * 10,
      duration: 0.8,
      ease: 'power2.out',
      stagger: 0.1
    });
  }

  expandCard(index: number) {
    if (this.activeIndex === index) {
      this.activeIndex = -1;
      this.fanCards();
      return;
    }

    this.activeIndex = index;
    const cards = Array.from(this.shadowRoot?.querySelectorAll('.card') || []);

    cards.forEach((card, i) => {
      if (i === index) {
        gsap.to(card, {
          rotationZ: 0,
          y: -50,
          z: 100,
          scale: 1.1,
          duration: 0.6,
          ease: 'power3.out',
          zIndex: 10
        });
      } else {
        gsap.to(card, {
          rotationZ: (i - this.founders.length / 2) * 15,
          y: 50 + Math.abs(i - this.founders.length / 2) * 30,
          z: -50,
          scale: 0.9,
          duration: 0.6,
          ease: 'power3.out',
          zIndex: 1
        });
      }
    });
  }

  render() {
    return html`
      <div class="deck">
        ${this.founders.map((founder, index) => html`
          <div
            class="card ${this.activeIndex === index ? 'active' : ''}"
            @click="${() => this.expandCard(index)}"
          >
            ${founder.image ? html`<img src="${founder.image}" alt="${founder.title}">` : ''}
            <h3>${founder.title}</h3>
            <p class="role">${founder.role}</p>
            <p class="bio">${founder.bio}</p>
          </div>
        `)}
      </div>
    `;
  }
}
