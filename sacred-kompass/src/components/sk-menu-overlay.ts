import { LitElement, html, css } from 'lit';
import { customElement, property } from 'lit/decorators.js';

@customElement('sk-menu-overlay')
export class SkMenuOverlay extends LitElement {
  @property({ type: Boolean }) isOpen = false;

  static styles = css`
    :host {
      display: block;
    }
    .overlay {
      position: fixed;
      inset: 0;
      background: var(--sk-earth);
      color: var(--sk-cream);
      z-index: var(--z-overlay);
      opacity: 0;
      pointer-events: none;
      transition: opacity var(--dur-base) var(--ease-out);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .overlay.open {
      opacity: 1;
      pointer-events: auto;
    }
    .close-btn {
      position: absolute;
      top: var(--sk-space-lg);
      right: var(--sk-section-x);
      background: none;
      border: none;
      color: var(--sk-cream);
      font-size: var(--fs-h3);
      cursor: pointer;
    }
    .nav-list {
      list-style: none;
      padding: 0;
      text-align: center;
    }
    .nav-list li {
      margin-bottom: var(--sk-space-md);
    }
    .nav-list a {
      color: var(--sk-cream);
      text-decoration: none;
      font-family: var(--sk-font-display);
      font-size: var(--fs-h2);
      transition: color var(--dur-fast) var(--ease-out);
    }
    .nav-list a:hover {
      color: var(--sk-gold);
    }
  `;

  toggleMenu() {
    this.isOpen = !this.isOpen;
    if (this.isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
  }

  render() {
    return html`
      <div class="overlay ${this.isOpen ? 'open' : ''}">
        <button class="close-btn" @click="${this.toggleMenu}" aria-label="Close menu">×</button>
        <nav>
          <ul class="nav-list">
            <li><a href="#offerings" @click="${this.toggleMenu}">Offerings</a></li>
            <li><a href="#about" @click="${this.toggleMenu}">About</a></li>
            <li><a href="#journal" @click="${this.toggleMenu}">Journal</a></li>
          </ul>
        </nav>
      </div>
    `;
  }
}
