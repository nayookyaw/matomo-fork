import { render, screen } from '@testing-library/vue';
import Metric from '@/view/Metric.vue';

const StubIcon = {
  template: `<span data-testid="stub-icon">Icon</span>`
};

describe('Metric.vue', () => {
  it('renders label and value', async () => {
    render(Metric, {
      props: { label: 'Total visits', value: 42 }
    });

    expect(screen.getByText('Total visits')).toBeTruthy();
    expect(screen.getByText(':')).toBeTruthy();
    expect(screen.getByText('42')).toBeTruthy();
  });

  it('renders labelIcon slot', async () => {
    render(Metric, {
      props: { label: 'Visitors', value: 7 },
      slots: {
        labelIcon: StubIcon.template
      }
    });

    expect(screen.getByTestId('stub-icon')).toBeTruthy();
  });
});
